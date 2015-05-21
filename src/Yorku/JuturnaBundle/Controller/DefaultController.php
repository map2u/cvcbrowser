<?php

namespace Yorku\JuturnaBundle\Controller;

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
 * <summary>This file is created for default controller with bundle YorkuJuturnaBundle</summary>
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Yorku\JuturnaBundle\Entity\TourismGeoms;
use Yorku\JuturnaBundle\Entity\TourismComments;
use Yorku\JuturnaBundle\Form\TourismCommentsType;
use Yorku\JuturnaBundle\Form\TourismGeomsType;
use Yorku\JuturnaBundle\Entity\Tourism;
use Yorku\JuturnaBundle\Form\TourismType;
use CrEOF\Spatial\ORM\Query\AST\Functions\PostgreSql\STGeomFromText;
use CrEOF\Spatial\PHP\Types\Geometry\GeometryInterface;
use CrEOF\Spatial\Tests\DBAL\Types\Geometry;

/**
 * default controller.
 *
 * @Route("/juturnadefault")
 */
class DefaultController extends Controller {

    /**
     * .
     *
     * @Route("/", name="juturnadefault_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {

        $_locale = $request->attributes->get('_locale', $request->getLocale());

        return $this->render('YorkuJuturnaBundle:Default:index.html.twig', array('_locale' => $_locale));
    }

    /**
     * .
     *
     * @Route("/about", name="juturnadefault_about")
     * @Method("GET")
     * @Template()
     */
    public function aboutAction(Request $request) {

        $_locale = $request->attributes->get('_locale', $request->getLocale());

        return $this->render('YorkuJuturnaBundle:Default:about.html.twig', array('_locale' => $_locale));
    }

    /**
     * .
     *
     * @Route("/station_homepage", name="juturnadefault_station_homepage")
     * @Method("GET")
     * @Template()
     */
    public function station_homepageAction(Request $request) {
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();
        $stations = $em->getRepository("YorkuJuturnaBundle:Station")->findBy(array(), array('code' => 'ASC'));
        return $this->render('YorkuJuturnaBundle:Default:station_homepage.html.twig', array('_locale' => $_locale, "stations" => $stations));
    }

    /**
     * .
     *
     * @Route("/homepage_mapstation", name="juturnadefault_mapstation_tabform")
     * @Method("GET")
     * @Template()
     */
    public function station_tabformAction(Request $request) {
        $columns = $request->get("columns") | 5;
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();
        $stations = $em->getRepository("YorkuJuturnaBundle:Station")->findBy(array(), array('code' => 'ASC'));
        return $this->render('YorkuJuturnaBundle:Default:station_tabform.html.twig', array('_locale' => $_locale, "stations" => $stations, 'columns' => $columns));
    }

    /**
     * .
     *
     * @Route("/bird_homepage", name="juturnadefault_bird_homepage")
     * @Method("GET")
     * @Template()
     */
    public function bird_homepageAction(Request $request) {
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("YorkuJuturnaBundle:Species")
                ->createQueryBuilder('p')
                ->where('p.images is not NULL');
        $species = $qb->getQuery()
                ->getResult();

        return $this->render('YorkuJuturnaBundle:Default:bird_homepage.html.twig', array('_locale' => $_locale, 'species' => $species));
    }

    /**
     * .
     *
     * @Route("/custom_feature", name="juturnadefault_custom_feature")
     * @Method("GET|POST")
     * @Template("YorkuJuturnaBundle:Default:customFeature.html.twig")
     */
    public function customFeatureAction(Request $request) {

        $entity = new TourismGeoms();
        $form = $this->createForm(new TourismGeomsType(), $entity);
        $conn = $this->get('database_connection');


        if ($request->getMethod() == "POST") {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $data = $form->getData();

                $dir = './uploads/customgeometry/styles';

                $file = $form['style_file']->getData();
                $filename = null;
                if ($file !== null) {
                    $filename = str_replace(" ", "_", $file->getClientOriginalName());
                    $file->move($dir, $file->getClientOriginalName());
                    rename($dir . '/' . $file->getClientOriginalName(), $dir . '/' . $filename);
                }

                $features = json_decode($form['geometry']->getData());

                if (count($features->features) > 0) {
                    $geomstr = '';
                    $points = '';

                    foreach ($features->features as $feature) {
                        $each_points = '';

                        if (is_array($feature->geometry->coordinates[0])) {
                            foreach ($feature->geometry->coordinates as $coordinate) {

                                if (is_array($coordinate)) {

                                    if (is_array($coordinate[0])) {
                                        foreach ($coordinate as $point) {
                                            if ($each_points === '') {
                                                $each_points = $point[0] . ' ' . $point[1];
                                            } else {
                                                $each_points = $each_points . ',' . $point[0] . ' ' . $point[1];
                                            }
                                        }
                                    } else {
                                        if ($each_points === '') {
                                            $each_points = $coordinate[0] . ' ' . $coordinate[1];
                                        } else {
                                            $each_points = $each_points . ',' . $coordinate[0] . ' ' . $coordinate[1];
                                        }
                                    }
                                } else {
                                    if ($each_points === '') {
                                        $each_points = $feature->geometry->coordinates[0][0] . ' ' . $feature->geometry->coordinates[0][1];
                                    } else {
                                        $each_points = $each_points . ',' . $feature->geometry->coordinates[0][0] . ' ' . $feature->geometry->coordinates[0][1];
                                    }
                                }
                            }
                        } else {
                            $each_points = $feature->geometry->coordinates[0] . ' ' . $feature->geometry->coordinates[1];
                        }

                        if ($points === '') {
                            $points = '(' . $each_points . ')';
                        } else {
                            $points = $points . ',(' . $each_points . ')';
                        }
                    }
                    ;
                    if (strtoupper($features->features[0]->geometry->type) === 'POLYGON') {
                        $points = '(' . $points . ')';
                    }
                    $name = $form['name']->getData();
                    $usercustomgeoms = $em->getRepository('YorkuJuturnaBundle:TourismGeoms')->findOneBy(array('user' => $this->getUser(), 'name' => $name));
                    if (($usercustomgeoms === null || count($usercustomgeoms) === 0) && (count($features) > 0)) {
                        $newusercustomgeoms = new TourismGeoms();
                        $newusercustomgeoms->setName($name);
                        $newusercustomgeoms->setStyle($filename);
                        $newusercustomgeoms->setUser($this->getUser());
                        if (count($features->features) > 0) {
                            $newusercustomgeoms->setGeometryType($features->features[0]->geometry->type);
                        }
                        $em->persist($newusercustomgeoms);
                        $em->flush();

                        $tableName = $em->getClassMetadata('YorkuJuturnaBundle:TourismGeoms')->getTableName();
                        if (count($features->features) > 1) {
                            $geomstr = 'MULTI' . strtoupper($features->features[0]->geometry->type);

                            $sql = "update " . $tableName . " set the_geom=St_GeomFromText('" . $geomstr . '(' . $points . ")',32617) where id=" . $newusercustomgeoms->getId();
                        } else {
                            $geomstr = strtoupper($features->features[0]->geometry->type);

                            $sql = "update " . $tableName . " set the_geom=St_GeomFromText('" . $geomstr . $points . "',32617) where id=" . $newusercustomgeoms->getId();
                        }

                        $stmt = $conn->query($sql);

                        return new JsonResponse(array(
                            'success' => true
                        ));
                    } else {

                        if (count($features->features) > 0) {

                            $usercustomgeoms->setGeometryType($features->features[0]->geometry->type);
                        }
                        $usercustomgeoms->setStyle($filename);
                        $em->persist($usercustomgeoms);
                        $em->flush();

                        $tableName = $em->getClassMetadata('YorkuJuturnaBundle:TourismGeoms')->getTableName();
                        if (count($features->features) > 1) {
                            $geomstr = 'MULTI' . strtoupper($features->features[0]->geometry->type);

                            $sql = "update " . $tableName . " set the_geom=St_GeomFromText('" . $geomstr . '(' . $points . ")',4326) where id=" . $usercustomgeoms->getId();
                        } else {
                            $geomstr = strtoupper($features->features[0]->geometry->type);

                            $sql = "update " . $tableName . " set the_geom=St_GeomFromText('" . $geomstr . $points . "',4326) where id=" . $usercustomgeoms->getId();
                        }

                        $stmt = $conn->query($sql);
                        return new JsonResponse(array(
                            'success' => true
                        ));
                    }
                }
            }
            return new JsonResponse(array(
                'success' => false
            ));
        }


        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * .
     *
     * @Route("/homepage_mapbird", name="default_mapbird_listform")
     * @Method("GET")
     * @Template()
     */
    public function bird_listformAction(Request $request) {
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();
        $species = $em->getRepository("YorkuJuturnaBundle:Species")->findBy(array(), array('speciesName' => 'ASC'));

        return $this->render('YorkuJuturnaBundle:Default:bird_listform.html.twig', array('_locale' => $_locale, 'species' => $species));
    }

    /**
     * .
     *
     * @Route("/homepage_maptourism", name="default_maptourism_listform")
     * @Method("GET")
     * @Template()
     */
    public function tourism_listformAction(Request $request) {
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();
        $tourisms = $em->getRepository("YorkuJuturnaBundle:Tourism")->findBy(array('isPublished' => true), array('name' => 'ASC'));

        return $this->render('YorkuJuturnaBundle:Default:tourism_listform.html.twig', array('_locale' => $_locale, 'tourisms' => $tourisms));
    }

    /**
     * .
     *
     * @Route("/homepage_add_new_tourismcomment", name="juturnadefault_add_tourism_comment")
     * @Method("GET|POST")
     * @Template("YorkuJuturnaBundle:Default:add_new_tourismcomment.html.twig")
     */
    public function add_new_tourismcommentAction(Request $request) {

        $_locale = $request->attributes->get('_locale', $request->getLocale());

        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $entity = new TourismComments();

        $tourism = $em->getRepository("YorkuJuturnaBundle:Tourism")->findOneById($id);
        $entity->setTourism($tourism);

        $userid = null;
        $tourismid = null;
        if ($tourism)
            $tourismid = $tourism->getId();
        if ($this->getUser())
            $userid = $this->getUser()->getId();
        $form = $this->createForm(new TourismCommentsType(), $entity, array('tourismid' => $tourismid, 'userid' => $userid));


        if ($request->getMethod() == 'POST') {

            $form->bind($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid) {
                $em->persist($entity);
                $em->flush();
                return new JsonResponse(array(
                    'success' => true
                ));
            }
            return new JsonResponse(array(
                'success' => false
            ));
        }

        return array(
            'id' => $id,
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * .
     *
     * @Route("/homepage_add_new_tourisminfo", name="juturnadefault_custom_feature_add_new_tourisminfo")
     * @Method("GET|POST")
     * @Template("YorkuJuturnaBundle:Default:add_new_tourisminfo.html.twig")
     */
    public function add_new_tourisminfoAction(Request $request) {

        $_locale = $request->attributes->get('_locale', $request->getLocale());

        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $entity = new Tourism();

        $tourismgeoms = $em->getRepository("YorkuJuturnaBundle:TourismGeoms")->findOneById($id);
        $tourismgeomsid = null;
        if ($tourismgeoms)
            $tourismgeomsid = $tourismgeoms->getId();
        $entity->setTourismgeoms($tourismgeoms);
        $form = $this->createForm(new TourismType(), $entity, array('tourismgeomsid' => $tourismgeomsid));


        if ($request->getMethod() == 'POST') {

            $form->bind($this->get('request'));
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid) {
                $em->persist($entity);
                $em->flush();
                $images_file = $form['images_file']->getData();
                $videos_file = $form['videos_file']->getData();
                $audios_file = $form['audios_file']->getData();

                $bsuccess = true;

                $images_array = array();
                $videos_array = array();
                $audios_array = array();

                $dir = './uploads/images/tourisms/';
                if (is_array($images_file)) {
                    foreach ($images_file as $file) {

                        if ($file != null) {
                            array_push($images_array, $file->getClientOriginalName());
                            $file->move($dir . 'pictures/' . $entity->getId(), $file->getClientOriginalName());
                        }
                    }
                } else {

                    if ($images_file != null) {
                        array_push($images_array, $images_file->getClientOriginalName());
                        $images_file->move($dir . 'pictures/' . $entity->getId(), $images_file->getClientOriginalName());
                    }
                }

                if (is_array($videos_file)) {
                    foreach ($videos_file as $file) {

                        if ($file != null) {
                            array_push($videos_array, $file->getClientOriginalName());
                            $file->move($dir . 'videos/' . $entity->getId(), $file->getClientOriginalName());
                        }
                    }
                } else {
                    if ($videos_file != null) {
                        array_push($videos_array, $videos_file->getClientOriginalName());
                        $videos_file->move($dir . 'videos/' . $entity->getId(), $videos_file->getClientOriginalName());
                    }
                }
                if (is_array($audios_file)) {
                    foreach ($audios_file as $file) {

                        if ($file != null) {
                            array_push($audios_array, $file->getClientOriginalName());
                            $file->move($dir . 'audios/' . $entity->getId(), $file->getClientOriginalName());
                        }
                    }
                } else {
                    if ($audios_file != null) {
                        array_push($audios_array, $audios_file->getClientOriginalName());
                        $audios_file->move($dir . 'audios/' . $entity->getId(), $audios_file->getClientOriginalName());
                    }
                }

                $entity->setImages(serialize($images_array));
                $entity->setVideos(serialize($videos_array));
                $entity->setAudios(serialize($audios_array));
                $em->persist($entity);
                $em->flush();
                return new JsonResponse(array(
                    'success' => true
                ));
            }
            return new JsonResponse(array(
                'success' => false
            ));
        }




        return array(
            'id' => $id,
            'entity' => $entity,
            'form' => $form->createView(),
            'tourismgeoms' => $tourismgeoms
        );
    }

    /**
     * .
     *
     * @Route("/detail_station", name="juturnadefault_detail_stations")
     * @Method("GET")
     * @Template()
     */
    public function detail_stationAction(Request $request) {
        $id = $request->get('id');
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();


        $station = $em->getRepository("YorkuJuturnaBundle:Station")->findOneById($id);
        return $this->render('YorkuJuturnaBundle:Default:detail_station.html.twig', array('_locale' => $_locale, 'station' => $station));
    }

    /**
     * .
     *
     * @Route("/detail_tourism", name="juturnadefault_detail_tourism")
     * @Method("GET")
     * @Template()
     */
    public function detail_tourismAction(Request $request) {
        $id = $request->get('id');
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();


        $tourism = $em->getRepository("YorkuJuturnaBundle:Station")->findOneById($id);
        return $this->render('YorkuJuturnaBundle:Default:detail_tourism.html.twig', array('_locale' => $_locale, 'tourism' => $tourism));
    }

    /**
     * .
     *
     * @Route("/popup_station", name="juturnadefault_popup_stations")
     * @Method("GET")
     * @Template()
     */
    public function popup_stationAction(Request $request) {
        $id = $request->get('id');
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();


        $station = $em->getRepository("YorkuJuturnaBundle:Station")->findOneById($id);
        return $this->render('YorkuJuturnaBundle:Default:popup_station.html.twig', array('_locale' => $_locale, 'station' => $station));
    }

    /**
     * .
     *
     * @Route("/popup_tourism", name="juturnadefault_popup_tourism")
     * @Method("GET")
     * @Template()
     */
    public function popup_tourismAction(Request $request) {
        $id = $request->get('id');
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();


        $tourism = $em->getRepository("YorkuJuturnaBundle:Station")->findOneById($id);
        return $this->render('YorkuJuturnaBundle:Default:popup_tourism.html.twig', array('_locale' => $_locale, 'tourism' => $tourism));
    }

    /**
     * .
     *
     * @Route("/adminhelp", name="jdefault_adminhelp")
     * @Method("GET")
     * @Template()
     */
    public function adminhelpAction(Request $request) {
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        return $this->render('YorkuJuturnaBundle:Default:adminhelp.html.twig', array('_locale' => $_locale));
    }

    /**
     * .
     *
     * @Route("/systemhelp", name="jdefault_systemhelp")
     * @Method("GET")
     * @Template()
     */
    public function systemhelpAction(Request $request) {
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        return $this->render('YorkuJuturnaBundle:Default:systemhelp.html.twig', array('_locale' => $_locale));
    }

}
