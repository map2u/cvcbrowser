<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Stations controller.
 *
 * @Route("/")
 */
class HomepageController extends Controller {

    /**
     * .
     *
     * @Route("/", name="homepage_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        $session = $request->getSession();
        $locale = $request->getLocale();
        $session->set('current_menu', "home");
        $em = $this->getDoctrine()->getManager();
        $description = $em->getRepository('YorkuJuturnaBundle:HomepageDescription')->findOneBy(array('active' => true), array("updatedAt" => 'desc'));
        $ecosystems = $em->getRepository('YorkuJuturnaBundle:EcoSystemService')->findAll();
        $wellbeings = $em->getRepository('YorkuJuturnaBundle:HumanWellBeingDomain')->findAll();

        return array('_locale' => $locale, 'current_menu' => "home", 'ecosystems' => $ecosystems, 'wellbeings' => $wellbeings, 'description' => $description);
    }

    /**
     * .
     *
     * @Route("/images", name="homepage_images")
     * @Method("GET")
     * @Template()
     */
    public function imagesAction(Request $request) {
        $type = $request->get("type");
        $locale = $request->getLocale();
        if (!isset($type) || $type == null) {
            $type = "Well-Being";
        }
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('YorkuJuturnaBundle:Category')->findOneByName($type);
        //    var_dump($category);
//        if (!isset($id)) {
//            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
//        }
//        if  ((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined'))) {
//            $usergeometries = new UserDrawGeometries();
//        } else {
        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('category' => $category));
//
//            $update_geom = true;
//        }
        return array('_locale' => $locale, 'image' => $image, 'type' => strtolower(str_replace("-", "_", $type)));
    }

    /**
     * .
     *
     * @Route("/flashs", name="homepage_flashs")
     * @Method("GET")
     * @Template()
     */
    public function flashsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $locale = $request->getLocale();
//        if (!isset($id)) {
//            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
//        }
//        if  ((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined'))) {
//            $usergeometries = new UserDrawGeometries();
//        } else {
        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
//
//            $update_geom = true;
//        }
        return array('_locale' => $locale, 'flashs' => $flashs);
    }

    /**
     * .
     *
     * @Route("/well_being", name="homepage_well_being")
     * @Method("GET")
     * @Template()
     */
    public function well_beingAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $id = $request->get("id");
        $locale = $request->getLocale();
        $session->set('current_menu', "well_being");
        $category = $em->getRepository('YorkuJuturnaBundle:Category')->findOneByName("Well-Being");
        if (isset($id) && intval($id) > 0) {
            $wellbeing = $em->getRepository('YorkuJuturnaBundle:HumanWellBeingDomain')->find($id);
        }
//        if (!isset($id)) {
//            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
//        }
//        if  ((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined'))) {
//            $usergeometries = new UserDrawGeometries();
//        } else {
        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('category' => $category));
//
//            $update_geom = true;
//        }


        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
//
//            $update_geom = true;
//        }
        return array('_locale' => $locale, 'wellbeing' => $wellbeing, 'image' => $image, 'flashs' => $flashs);
    }

    /**
     * .
     *
     * @Route("/ecosystems", name="homepage_ecosystems")
     * @Method("GET")
     * @Template()
     */
    public function ecosystemsAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $id = $request->get("id");
        $locale = $request->getLocale();
        $session->set('current_menu', "ecosystems");
        $category = $em->getRepository('YorkuJuturnaBundle:Category')->findOneByName("Ecosystems");
        if (isset($id) && intval($id) > 0) {
            $ecosystems = $em->getRepository('YorkuJuturnaBundle:EcoSystemService')->find($id);
        }
//        if (!isset($id)) {
//            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
//        }
//        if  ((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined'))) {
//            $usergeometries = new UserDrawGeometries();
//        } else {
        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('category' => $category));
//
//            $update_geom = true;
//        }


        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
//
//            $update_geom = true;
//        }
        return array('_locale' => $locale, 'ecosystems' => $ecosystems, 'image' => $image, 'flashs' => $flashs);


//        $em = $this->getDoctrine()->getManager();
//        $session = $request->getSession();
//        $locale = $request->getLocale();
//        $session->set('current_menu', "ecosystems");
//        $category = $em->getRepository('YorkuJuturnaBundle:Category')->findOneByName("Ecosystems");
//
////        if (!isset($id)) {
////            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
////        }
////        if  ((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined'))) {
////            $usergeometries = new UserDrawGeometries();
////        } else {
//        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('category' => $category));
//
//        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
//
//        return array('_locale' => $locale, 'image' => $image, 'flashs' => $flashs);
    }

    /**
     * .
     *
     * @Route("/map", name="homepage_map")
     * @Method("GET")
     * @Template()
     */
    public function mapAction(Request $request) {
        $session = $request->getSession();
        $locale = $request->getLocale();
        $id = $request->get('id');
        $view = $request->get('view');
        $session->set('current_menu', "map");
        $em = $this->getDoctrine()->getManager();
        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();

        return array('_locale' => $locale, 'flashs' => $flashs, 'view' => $view, 'id' => $id);
    }

    /**
     * .
     *
     * @Route("/stories", name="homepage_stories")
     * @Method("GET")
     * @Template()
     */
    public function storiesAction(Request $request) {
        $session = $request->getSession();
        $session->set('current_menu', "stories");
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('YorkuJuturnaBundle:Category')->findOneByName("Ecosystems");

//        if (!isset($id)) {
//            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
//        }
//        if  ((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined'))) {
//            $usergeometries = new UserDrawGeometries();
//        } else {
        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
//
//            $update_geom = true;
//        }
        return array('_locale' => $locale, 'flashs' => $flashs);
    }

    /**
     * .
     *
     * @Route("/contact_us", name="homepage_contact_us")
     * @Method("GET")
     * @Template()
     */
    public function contact_usAction(Request $request) {
        $session = $request->getSession();
        $session->set('current_menu', "contact_us");
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
//        if (!isset($id)) {
//            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
//        }
//        if  ((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined'))) {
//            $usergeometries = new UserDrawGeometries();
//        } else {
        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
//
//            $update_geom = true;
//        }
        return array('_locale' => $locale, 'flashs' => $flashs);
    }

    /**
     * .
     *
     * @Route("/about_us", name="homepage_about_us")
     * @Method("GET")
     * @Template()
     */
    public function about_usAction(Request $request) {
        $session = $request->getSession();
        $locale = $request->getLocale();
        $session->set('current_menu', "about_us");
        $em = $this->getDoctrine()->getManager();
//        if (!isset($id)) {
//            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
//        }
//        if  ((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined'))) {
//            $usergeometries = new UserDrawGeometries();
//        } else {
        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
//
//            $update_geom = true;
//        }
        return array('_locale' => $locale, 'flashs' => $flashs);
    }

    /**
     * .
     *
     * @Route("/uploadstory", name="homepage_uploadstory")
     * @Method("GET|POST")
     * @Template()
     */
    public function uploadstoryAction(Request $request) {
        $locale = $request->getLocale();
        return array('_locale' => $locale);
    }

    /**
     * .
     *
     * @Route("/footer", name="homepage_footer")
     * @Method("GET")
     * @Template()
     */
    public function footerAction(Request $request) {
        $locale = $request->getLocale();
        return array('_locale' => $locale);
    }

    /**
     * .
     *
     * @Route("/leftsidebar_view", name="homepage_leftsidebar_view", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function leftsidebar_viewAction(Request $request) {
        $locale = $request->getLocale();
        $view = $request->get("view");
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();

        $entities = null;
        $story = null;
        if (isset($view) && isset($id) && intval($id) > 0) {
            if ($view === 'benefit') {
                $entities = $em->getRepository('YorkuJuturnaBundle:IndicatorBenefit')->find(intval($id));
            }
            if ($view === 'story') {
                $story = $em->getRepository('YorkuJuturnaBundle:Story')->find(intval($id));
            }
        }
        return array('_locale' => $locale, 'entities' => $entities, 'story' => $story);
    }

}
