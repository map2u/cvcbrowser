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
 * <date>created at 2015/10/21</date>
 * <date>last updated at 2015/10/21</date>
 * <summary>This file is created for Measure controller with bundle YorkuJuturnaBundle</summary>
 * <purpose>all Report related actions process in this controller</purpose>
 */

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Types\Type;

//use \Imagick;

Type::overrideType('datetime', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('datetimetz', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('time', 'Doctrine\DBAL\Types\VarDateTimeType');
define('PDF_MARGIN_HEADER', 10);

/**
 * Measure controller.
 *
 * @Route("/measure")
 */
class MeasureController extends Controller {

    /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/", name="measure_index", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $mapmeasurements = null;
        if ($user) {
            $mapmeasurements = $em->getRepository('YorkuJuturnaBundle:MapMeasurement')->findBy(array('user' => $user));
        }
        return array("mapmeasurements" => $mapmeasurements);
    }

    /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/new", name="measure_new", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request) {
        $user = $this->getUser();
        $type = $request->get("type");

        return array("type" => $type);
    }

    /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/save", name="measure_save", options={"expose"=true})
     * @Method("POST")
     * @Template()
     */
    public function saveAction(Request $request) {
        $user = $this->getUser();
        $conn = $this->get('database_connection');
        $em = $this->getDoctrine()->getManager();
        if ($user) {
            $name = $request->get("name");
            $type = $request->get("type");
            $layerType = $request->get("layerType");
            $radius = $request->get("radius");

            $the_geom = $request->get("the_geom");
            if (gettype($the_geom) === 'string') {
                $the_geom = json_decode(str_replace("'", '"', $the_geom));
            }
            $mapmeasurement = $em->getRepository('YorkuJuturnaBundle:MapMeasurement')->findOneBy(array('user' => $user, 'name' => $name));
            if ($mapmeasurement === null || count($mapmeasurement) === 0) {
                $mapmeasurement = new \Yorku\JuturnaBundle\Entity\MapMeasurement();
                $mapmeasurement->setUser($user);
                $mapmeasurement->setName($name);
            }
            if (isset($radius) && $radius !== null) {
                $mapmeasurement->setRadius($radius);
            }
            $mapmeasurement->setType($type);
            $mapmeasurement->setLayerType($layerType);
            $em->persist($mapmeasurement);
            $em->flush();
            $id = $mapmeasurement->getId();
            //$feature_geojson = $the_geom->geometry;
            if ($layerType === 'marker' || $layerType === 'circle' || $the_geom->geometry->type === 'Point') {
                $lng = $the_geom->geometry->coordinates[0];
                $lat = $the_geom->geometry->coordinates[1];

                $sql = "UPDATE map_measurements set the_geom = ST_GeomFromText('POINT($lng $lat)', 4326) where id=$id";
            }

            if ($the_geom->geometry->type === 'Polygon') {
                $points = '';

                foreach ($the_geom->geometry->coordinates[0] as $point) {

                    if ($points === '') {
                        $points = "$point[0]  $point[1]";
                    } else {
                        $points = $points . ",$point[0]  $point[1]";
                    }
                }
                $sql = "UPDATE map_measurements set the_geom = ST_GeomFromText('POLYGON(($points))', 4326) where id=$id";
            }
            if ($the_geom->geometry->type === 'LineString') {
                $points = '';

                foreach ($the_geom->geometry->coordinates as $point) {

                    if ($points === '') {
                        $points = "$point[0]  $point[1]";
                    } else {
                        $points = $points . ",$point[0]  $point[1]";
                    }
                }

                $sql = "UPDATE map_measurements set the_geom = ST_GeomFromText('LINESTRING($points)', 4326) where id=$id";
            }
            $stmt = $conn->query($sql);
            return new JsonResponse(array('success' => true, 'message' => "The measurement saved!"));
        } else {
            return new JsonResponse(array('success' => false, 'message' => "Sorry,only logged in user can save it!"));
        }
    }

    /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/deletemeasurement", name="measure_deletemeasurement", options={"expose"=true})
     * @Method("POST")
     * @Template()
     */
    public function deletemeasurementAction(Request $request) {
        $id = $request->get("id");
        $user = $this->getUser();
        $conn = $this->get('database_connection');
        $em = $this->getDoctrine()->getManager();
        if ($user) {
            if (isset($id) && intval($id) > 0) {
                $mapmeasurement = $em->getRepository('YorkuJuturnaBundle:MapMeasurement')->findOneBy(array('user' => $user, 'id' => $id));
                if ($mapmeasurement === null || count($mapmeasurement) === 0) {
                    return new JsonResponse(array('sucess' => false, 'message' => "Sorry,Measurement not found by id:$id!"));
                } else {
                    $em->remove($mapmeasurement);
                    //          $em->persist($mapmeasurement);
                    $em->flush();
                    return new JsonResponse(array('success' => true, 'message' => "Measurement has been successfully deleted!", "id" => $id));
                }
            } else {
                return new JsonResponse(array('success' => false, 'message' => "Sorry,Invalide id:$id!"));
            }
        } else {
            return new JsonResponse(array('success' => false, 'message' => "Sorry,only logged in user can delete it!"));
        }
    }

    /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/showmeasurement", name="measure_showmeasurement_on_map", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function showmeasurementAction(Request $request) {
        $id = $request->get("id");
        $conn = $this->get('database_connection');
        $user = $this->getUser();
        if (isset($id) && intval($id) > 0 && $user) {
            $sql = "select id,name,type,layer_type,radius,st_asgeojson(the_geom) as geom from map_measurements where id=" . $id;
            $result = $conn->fetchAll($sql);
            if (count($result) === 1) {
                return new JsonResponse(array('sucess' => true, 'message' => "successfully loaded!",'name'=>$result[0]['name'], 'type' => $result[0]['type'], 'layerType' => $result[0]['layer_type'], 'radius' => $result[0]['radius'], 'data' => array("id" => $id, "geom" => $result[0]['geom'])));
            } else {
                return new JsonResponse(array('sucess' => false, 'message' => "Sorry,this measurement id " . $id . " not found!"));
            }
        } else {
            return new JsonResponse(array('sucess' => false, 'message' => "Sorry,only logged in user can load measurement!"));
        }
    }

}
