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
 * <summary>This file is extend of Map2u\CoreBundle\Controller\DrawController</summary>
 * <purpose>expose of routing of Map2u\CoreBundle\Controller\DrawController , add custom actions in this controller and override the old actions</purpose>
 */

namespace Application\Map2u\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Paradigma\Bundle\ImageBundle\Libs\ImageSize;
use Paradigma\Bundle\ImageBundle\Libs\ImageResizer;
use Yorku\JuturnaBundle\Entity\Story;
use Application\Map2u\CoreBundle\Entity\UserDrawGeometries;
use Map2u\CoreBundle\Controller\LayerController as BaseController;
use Map2u\CoreBundle\Controller\DefaultMethods;
use Gaufrette\Exception;
use Application\Sonata\UserBundle\Entity\User;

/**
 * Welcome controller.
 *
 * @Route("/layer")
 */
class LayerController extends BaseController {

    /**
     * get layer geom as geojson.
     * params: ogc_fid and userboundary_id
     * @Route("/savesequence", name="layer_savesequence", options={"expose"=true})
     * @Method("POST")
     */
    public function savesequenceAction(Request $request) {
        $user = $this->getUser();
        if ($user) {
            $name = $request->get("name");
            $sequence = $request->get("sequence");
            $em = $this->getDoctrine()->getManager();
            $sequence_entity = $em->getRepository("Map2uCoreBundle:LayerDisplaySequence")->findOneBy(array("user" => $user, "name" => $name));
            if ($sequence_entity === null) {
                $sequence_entity = new \Map2u\CoreBundle\Entity\LayerDisplaySequence();
                $sequence_entity->setUser($user);
                $sequence_entity->setName($name);
                $sequence_entity->setDefault(false);
            }
            $sequence_entity->setSequence(json_encode($sequence));
            $em->persist($sequence_entity);
            $em->flush();
            return new JsonResponse(array('success' => true, 'message' => 'Layer display sequence has been successfully saved!', 'data' => array('id' => $sequence_entity->getId(), 'name' => $sequence_entity->getName(), 'sequence' => json_decode($sequence_entity->getSequence()))));
        } else {
            return new JsonResponse(array('success' => false, 'message' => 'Please Login First'));
        }
    }

    /**
     * get layer geom as geojson.
     * params: ogc_fid and userboundary_id
     * @Route("/editstyle", name="layer_editstyle", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function editstyleAction(Request $request) {
        $layer = $request->get("layer");
        $features = $request->get("features");
        var_dump($layer);
        var_dump($features);
    }

    /**
     * get layer geom as geojson.
     * params: ogc_fid and userboundary_id
     * @Route("/loadsequence", name="layer_loadsequence", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function loadsequenceAction(Request $request) {
        $user = $this->getUser();
        if ($user) {
            $em = $this->getDoctrine()->getManager();
            $id = $request->get("id");
            $sequence = array();
            if (strlen($id) === 36) {
                $sequence_entity = $em->getRepository("Map2uCoreBundle:LayerDisplaySequence")->find($id);
                if ($sequence_entity) {
                    $sequence = json_decode($sequence_entity->getSequence());
                    return new JsonResponse(array('success' => true, 'message' => 'Layer display sequence has been successfully loaded!', 'data' => $sequence));
                } else {
                    return new JsonResponse(array('success' => false, 'message' => 'Layer display sequence id:' . $id . ' has not been found!'));
                }
            } else {

                $sequence_entities = $em->getRepository("Map2uCoreBundle:LayerDisplaySequence")->findBy(array("user" => $user));

                return array('sequence' => $sequence_entities);
            }
        } else {
            return new JsonResponse(array('success' => false, 'message' => 'Please Login First'));
        }
    }

    /**
     * get layer geom as geojson.
     * params: ogc_fid and userboundary_id
     * @Route("/geom", name="layer_geom", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function geomAction(Request $request) {
        $id = $request->get("id");
        $layertype = $request->get("layertype");
        $sld_path = $this->get('kernel')->getRootDir() . '/../Data/sld/';

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $spatial = null;

        $sld = null;
        $hostname = null;
        $layername = null;
        $label_field = '';
        $layer = $em->getRepository($this->getParameter("map2u.core.layer.class"))->find($id);
        $stories_class = $em->getRepository($this->getParameter("map2u.core.story.class"));
        if ($layer) {
            if ($layer->getLayerType() === 'spatialfile' || $layer->getLayerType() === 'cluster') {
                $spatial = $this->getLayerSpatialfile($layer);
            }
            if ($layer->getLayerType() === 'geoserver') {
                $layerproperty = json_decode($layer->getLayerProperty());
                if ($layerproperty) {
                    $hostname = $layerproperty->wmsHostName;
                    $layername = $layerproperty->wmsLayerName;
                }
            }
            $label_field = $layer->getLabelField();
            if ($layer->getLayerType() === 'story' && $stories_class !== null) {

                $conn = $this->get('database_connection');
                $layerproperty = json_decode($layer->getLayerProperty());
                $story_type = null;
                if ($layerproperty && isset($layerproperty->story_type)) {
                    $story_type = $layerproperty->story_type;
                }
                if ($story_type) {

//                     $sql = "SELECT  row_to_json(fc) as geom FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features FROM (SELECT 'Feature' As type, ST_AsGeoJSON(lg.the_geom::geography)::json As geometry
//    , row_to_json(lp) As properties
//   FROM " . $em->getClassMetadata($stories_class->getClassName())->getTableName(). " As lg 
//         INNER JOIN (SELECT id, story_name, image_file,story_file  FROM ".$em->getClassMetadata($stories_class->getClassName())->getTableName()." where storytype_id='" . $story_type . "') As lp 
//       ON lg.id = lp.id  and lg.the_geom is not null) As f )  As fc";
//
//            $datatype = 'geojson';
////        $features = $conn->fetchAll("select id, " . implode(',', $column_names) . ", st_asgeojson(the_geom::geography) as the_geom from spatial_" . str_replace("-", "_", $layer->getSpatialfile()->getId()));
//            $topojson = $conn->fetchAll($sql);
//            $spatial['spatial']=$topojson;
//            $spatial['datatype']=$datatype;

                    $spatial = $conn->fetchAll("select id, story_name, image_file,story_file , st_x(ST_Centroid(the_geom)) as lng,st_y(ST_Centroid(the_geom)) as lat  from " . $em->getClassMetadata($stories_class->getClassName())->getTableName() . " where storytype_id='" . $story_type . "'");
                } else {
                    $spatial = $conn->fetchAll("select id, story_name, image_file,story_file , st_x(ST_Centroid(the_geom)) as lng,st_y(ST_Centroid(the_geom)) as lat  from " . $em->getClassMetadata($stories_class->getClassName())->getTableName());
                }
                // convert serialzed image names to json type
//                foreach ($spatial as $ee) {
//                    if ($ee['image_file'] !== null && $ee['image_file'][0] !== '[') {
//                        $conn->fetchAll("update " . $em->getClassMetadata($stories_class->getClassName())->getTableName() . " set image_file='" . json_encode(unserialize($ee['image_file'])) . "' where  id='" . $ee['id'] . "'");
//                    }
//                }
            }
            $sld = $layer->getSld();

            if (($sld === null || $sld === '') && $layer->getSldFileName() !== '' && $layer->getSldFileName() !== null) {
                $sld = DefaultMethods::getSldContent($this, $layer->getSldFileName());
            }

            return new JsonResponse(array('success' => true, 'layerType' => $layer->getLayerType(), 'layerPosition' => $layer->getPosition(), 'sld' => $sld, 'layer_id' => $layer->getId(), 'label_field' => $label_field, 'layer_name' => $layer->getName(), 'layer_property' => json_decode($layer->getLayerProperty()), 'data' => $spatial));
        }
        return new JsonResponse(array('success' => true, 'layer_id' => null, 'sld' => $sld, 'layerType' => null, 'layer_name' => null, 'data' => $spatial));
    }

}
