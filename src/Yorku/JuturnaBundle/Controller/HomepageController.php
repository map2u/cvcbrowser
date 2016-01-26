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
use Map2u\CoreBundle\Controller\DefaultMethods;

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
        $category = $em->getRepository('YorkuJuturnaBundle:ContentCategory')->findOneByName($type);

        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('contentCategory' => $category));
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
        $category = $em->getRepository('YorkuJuturnaBundle:ContentCategory')->findOneByName("Story");
        $stories = null;
        if (isset($id) && intval($id) > 0) {
            $stories = $em->getRepository('YorkuJuturnaBundle:Story')->find($id);
        }
        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('contentCategory' => $category));

        $flashs = $em->getRepository('YorkuJuturnaBundle:HomepageFlash')->findAll();

        return array('_locale' => $locale, 'stories' => $stories, 'image' => $image, 'flashs' => $flashs, "category" => $category);
    }

    /**
     * .
     *
     * @Route("/spatialfiletrans", name="homepage_spatialfiletrans")
     * @Method("GET")

     */
    public function spatialfiletransAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $path = getenv('PATH');
        putenv("PATH=$path:/opt/local/bin");
        $conn = $this->get("database_connection");
        $sql = "select * from useruploadfile";
         $source_dir = $this->get('kernel')->getRootDir() . '/../Data/uploads';


        $results = $conn->fetchAll($sql);
        foreach ($results as $result) {
            //  var_dump($result['id2']);
            $spatialfiledir = $this->get('kernel')->getRootDir() . '/../Data/uploads/spatialfiles/spatial_' . str_replace('-', '_', $result['id2']);
            shell_exec('rm '.$spatialfiledir.'/u'.$result['file_name2']);
//            
//            $sql = "select * from pg_tables where tablename='useruploadfile_geoms_" . $result['id'] . "' and schemaname='public'";
//            $cresult = $conn->fetchAll($sql);
//            if (count($cresult) > 0) {
//                $sql = " drop table IF EXISTS spatial_" . str_replace('-', '_', $result['id2']);
//                $conn->fetchAll($sql);
//
//                $sql = "select * into spatial_" . str_replace('-', '_', $result['id2']) . " from useruploadfile_geoms_" . $result['id'];
//                $conn->fetchAll($sql);
//                $sql = "alter table spatial_" . str_replace('-', '_', $result['id2']) . " add column id uuid default uuid_generate_v4()";
//                $conn->fetchAll($sql);
//
//                $geo_type = DefaultMethods::getGeometryType($conn, 'spatial_' . str_replace('-', '_', $result['id2']), 'the_geom');
//                var_dump($geo_type);
//     //           $columns = unserialize($result['field_list']);
// $columns = DefaultMethods::getTableColumns($this, "spatial_" . str_replace('-', '_', $result['id2']));
//                var_dump($columns);
//                $column_name_array = array();
//                array_push($column_name_array, 'id');
//                foreach ($columns as $column) {
//                    array_push($column_name_array, $column["column_name"]);
//                }
//                var_dump($column_name_array);
//                $filename = 'spatial_' . str_replace('-', '_', $result['id2']);
//
//                $column_names = implode(',', $column_name_array);
//                var_dump($column_names);
//                $geom_column = "the_geom";
//                // delete existing geojson file, ogr2ogr not update or auto overwrite geojson file
//                if (file_exists($spatialfiledir . '/' . $filename . '.geojson')) {
//                    shell_exec("rm -rf " . $spatialfiledir . '/' . $filename . '.geojson');
//                }
//
//
//                $sql2shapefile = 'ogr2ogr -overwrite -unsetFieldWidth -f "GeoJSON" ' . $spatialfiledir . '/' . $filename . '.geojson PG:"host=127.0.0.1 user=jzhao dbname=cvcbrowser3 password=jzhao" -nlt ' . $geo_type . ' -sql "SELECT ' . $column_names . ',' . $geom_column . ' as the_geom FROM ' . $filename . '" 2>&1';
//
//
//                $ogr2ogr_output = shell_exec($sql2shapefile);
//
//               
//                $topojsonfile = 'topojson -p -o ' . $spatialfiledir . '/' . $filename . '.topojson  ' . $spatialfiledir . '/' . $filename . '.geojson  2>&1';
//
//
//                $output = shell_exec($topojsonfile);
//
//                $zipfile = "zip -r " . $spatialfiledir . '/' . $filename . '.zip  ' . $spatialfiledir . '/' . $filename . '.topojson   2>&1';
//
//                $output = shell_exec($zipfile);
//            }
//            
//            
//            
            
            
            
            
            
            
            
//            if (!file_exists($spatialfiledir)) {
//                shell_exec("mkdir -p " . $spatialfiledir);
//            }
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $result['file_name2']);

            $handler = opendir($source_dir . "/1/shapefile");
          //  var_dump($source_dir . "/1/shapefile". "<br>");
// open directory and walk through the filenames
            while ($file = readdir($handler)) {
             //   var_dump($file);
                // if file isn't this directory or its parent, add it to the results
                if ($file != "." && $file != "..") {

                    // check with regex that the file format is what we're expecting and not something else
                    if (preg_match('#^(u' . $result['id'] . '_' . $filename . ')#', $file)) {
shell_exec("cp ".$source_dir . "/1/shapefile/".$file." ".$spatialfiledir.'/'.  str_replace('u'.$result['id'] . '_', '', $file));
                       // var_dump($file) . "<br>";
                    }
                }
            }
            var_dump("<br>");
            //   var_dump($filename) . "<br>" . "<br>" . "<br>";
        }
        return new \Symfony\Component\HttpFoundation\Response();
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
        $category = $em->getRepository('YorkuJuturnaBundle:ContentCategory')->findOneByName("Well-Being");
        $wellbeing = null;
        if (isset($id) && intval($id) > 0) {
            $wellbeing = $em->getRepository('YorkuJuturnaBundle:HumanWellBeingDomain')->find($id);
        }

        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('contentCategory' => $category));

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
        $category = $em->getRepository('YorkuJuturnaBundle:ContentCategory')->findOneByName("Ecosystems");
        $ecosystems = null;
        if (isset($id) && intval($id) > 0) {
            $ecosystems = $em->getRepository('YorkuJuturnaBundle:EcoSystemService')->find($id);
        }

        $image = $em->getRepository('YorkuJuturnaBundle:HomepageImage')->findOneBy(array('contentCategory' => $category));


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
        $category = $em->getRepository('YorkuJuturnaBundle:ContentCategory')->findOneByName("Ecosystems");
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
