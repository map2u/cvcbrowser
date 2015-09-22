<?php

/**
 * <copyright>
 * This file/program is free and open source software released under the GNU General Public
 * License version 3, and is distributed WITHOUT ANY WARRANTY. A copy of the GNU General
 * Public Licence is available at http://www.gnu.org/licenses
 * </copyright>
 *
 * <author>Shuilin (Joseph) Zhao</author>
 * <company>SpEAR Lab, Faculty of Environmental Studies, York University
 * <email>zhaoshuilin2004@yahoo.ca</email>
 * <date>created at 2014/01/06</date>
 * <date>last updated at 2015/03/11</date>
 * <summary>This file is created for Homepage controller with bundle YorkuJuturnaBundle</summary>
 * <purpose>all actions process related Homepage in this controller</purpose>
 */

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Yorku\JuturnaBundle\Form\ContactType;

/**
 * Homepage controller.
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
        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('category' => $category));
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
        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
        return array('_locale' => $locale, 'flashs' => $flashs);
    }

    /**
     * .
     *
     * @Route("/story", name="homepage_story")
     * @Method("GET")
     * @Template()
     */
    public function storyAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $id = $request->get("id");
        $locale = $request->getLocale();
        $session->set('current_menu', "story");
        $category = $em->getRepository('YorkuJuturnaBundle:Category')->findOneByName("Story");
        $stories = null;
        if (isset($id) && intval($id) > 0) {
            $stories = $em->getRepository('YorkuJuturnaBundle:Story')->find($id);
        }
        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('category' => $category));

        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();

        return array('_locale' => $locale, 'stories' => $stories, 'image' => $image, 'flashs' => $flashs, "category" => $category);
    }

    /**
     * .
     *
     * @Route("/storydetail", name="homepage_storydetail")
     * @Method("GET")
     * @Template()
     */
    public function storydetailAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $id = $request->get("id");
        $locale = $request->getLocale();
        $session->set('current_menu', "story");
        $story = null;
        if (isset($id) && intval($id) > 0) {
            $story = $em->getRepository('YorkuJuturnaBundle:Story')->find($id);
        }
        return array('_locale' => $locale, 'story' => $story);
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
        $wellbeing = null;
        if (isset($id) && intval($id) > 0) {
            $wellbeing = $em->getRepository('YorkuJuturnaBundle:HumanWellBeingDomain')->find($id);
        }

        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('category' => $category));

        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();

        return array('_locale' => $locale, 'wellbeing' => $wellbeing, 'image' => $image, 'flashs' => $flashs, "category" => $category);
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
        $ecosystems = null;
        if (isset($id) && intval($id) > 0) {
            $ecosystems = $em->getRepository('YorkuJuturnaBundle:EcoSystemService')->find($id);
        }

        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('category' => $category));


        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();

        return array('_locale' => $locale, 'ecosystems' => $ecosystems, 'image' => $image, 'flashs' => $flashs, "category" => $category);
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
        $benefits = null;
        if ($view === 'benefit' && isset($id) && intval($id) > 0) {
            $benefits = $em->getRepository('YorkuJuturnaBundle:IndicatorBenefit')->find($id);
        }

        return array('_locale' => $locale, 'benefits' => $benefits, 'flashs' => $flashs, 'view' => $view, 'id' => $id);
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
        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
        return array('_locale' => $locale, 'flashs' => $flashs);
    }

    /**
     * .
     *
     * @Route("/contact_us", name="homepage_contact_us")
     * @Method("GET|POST")
     * @Template()
     */
    public function contact_usAction(Request $request) {
        $session = $request->getSession();
        //   $session->set('current_menu', "contact_us");
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $contact = new \Yorku\JuturnaBundle\Entity\Contact();
        $form = $this->createForm(new ContactType(), $contact);


        $flash_message = null;
        if ($request->getMethod() == "POST") {

            $form->bind($request);
            if ($form->isValid()) {
                $ipaddress = $request->getClientIp();
                $contact->setIpaddress($ipaddress);
                $em->persist($contact);
                $flash_message = "Contact info successfully submitted!";
                $em->flush();
            } else {
                $flash_message = "Contact info submit failed!";
            }
            return $this->redirect($this->generateUrl('contact_us_edit', array('_locale' => $locale, 'form' => $form->createView(), "flash_message" => $flash_message)));
        }
        return array('_locale' => $locale, 'form' => $form->createView(), "flash_message" => $flash_message);
    }

    /**
     * .
     *
     * @Route("/contact_us_edit", name="homepage_contact_us_edit")
     * @Method("GET")
     * @Template()
     */
    public function contact_us_editAction(Request $request) {

        $locale = $request->getLocale();

        $contact = new \Yorku\JuturnaBundle\Entity\Contact();
        $form = $this->createForm(new ContactType(), $contact);
        $flash_message = null;
        return array('_locale' => $locale, 'form' => $form->createView(), "flash_message" => $flash_message);
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
        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();
        return array('_locale' => $locale, 'flashs' => $flashs);
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
            if ($view === 'stories' || $view === 'story') {
                $story = $em->getRepository('YorkuJuturnaBundle:Story')->find(intval($id));
            }
        }
        return array('_locale' => $locale, 'view' => $view, 'entities' => $entities, 'story' => $story);
    }

    /**
     * .
     *
     * @Route("/benefit", name="homepage_benefit")
     * @Method("GET")
     * @Template()
     */
    public function benefitAction(Request $request) {
        $id = $request->get("id");
        $benefit = null;
        $em = $this->getDoctrine()->getManager();
        if (isset($id) && intval($id) > 0) {
            $benefit = $em->getRepository('YorkuJuturnaBundle:IndicatorBenefit')->find(intval($id));
        }
        return array('benefit' => $benefit);
    }

}
