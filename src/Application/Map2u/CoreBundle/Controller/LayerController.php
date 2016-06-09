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
     * @Route("/loadsequence", name="layer_loadsequence", options={"expose"=true})
     * @Method("POST")
     */
    public function loadsequenceAction(Request $request) {
        $user = $this->getUser();
        if ($user) {

            $sequence = array();
            $em = $this->getDoctrine()->getManager();
            $sequence_entities = $em->getRepository("Map2uCoreBundle:LayerDisplaySequence")->findBy(array("user" => $user));
            foreach ($sequence_entities as $sequence_entity) {
                array_push($sequence, array("id" => $sequence_entity->getId(), "name" => $sequence_entity->getName()));
            }
            return new JsonResponse(array('success' => true, 'message' => 'Layer display sequence has been successfully loaded!', 'data' => $sequence));
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
        $layer = $em->getRepository($this->getParameter("map2u.core.layer.class"))->find($id);
        $stories_class = $em->getRepository($this->getParameter("map2u.core.story.class"));
        if ($layer) {
            if ($layer->getLayerType() === 'spatialfile') {
                $spatial = $this->getLayerSpatialfile($layer);
            }
            if ($layer->getLayerType() === 'geoserver') {
                $layerproperty = json_decode($layer->getLayerProperty());
                if ($layerproperty) {
                    $hostname = $layerproperty->wmsHostName;
                    $layername = $layerproperty->wmsLayerName;
                }
            }

            if ($layer->getLayerType() === 'story' && $stories_class !== null) {

                $conn = $this->get('database_connection');
                $layerproperty = json_decode($layer->getLayerProperty());
                $story_type = null;
                if ($layerproperty && isset($layerproperty->story_type)) {
                    $story_type = $layerproperty->story_type;
                }
                if ($story_type) {
                    $spatial = $conn->fetchAll("select id, story_name, image_file,story_file , st_x(ST_Centroid(the_geom)) as lng,st_y(ST_Centroid(the_geom)) as lat  from " . $em->getClassMetadata($stories_class->getClassName())->getTableName() . " where storytype_id='" . $story_type . "'");
                } else {
                    $spatial = $conn->fetchAll("select id, story_name, image_file,story_file , st_x(ST_Centroid(the_geom)) as lng,st_y(ST_Centroid(the_geom)) as lat  from " . $em->getClassMetadata($stories_class->getClassName())->getTableName());
                }
                // convert serialzed image names to json type
                foreach ($spatial as $ee) {
                    if ($ee['image_file'] !== null && $ee['image_file'][0] !== '[') {
                        $conn->fetchAll("update " . $em->getClassMetadata($stories_class->getClassName())->getTableName() . " set image_file='" . json_encode(unserialize($ee['image_file'])) . "' where  id='" . $ee['id'] . "'");
                    }
                }
            }
            if ($layer->getSldFileName() !== '' && $layer->getSldFileName() !== null) {
                $sld = DefaultMethods::getSldContent($this, $layer->getSldFileName());
            }

            return new JsonResponse(array('success' => true, 'layerType' => $layer->getLayerType(), 'layerPosition' => $layer->getPosition(), 'sld' => $sld, 'layer_id' => $layer->getId(), 'layer_name' => $layer->getName(), 'layer_property' => json_decode($layer->getLayerProperty()), 'data' => $spatial));
        }
        return new JsonResponse(array('success' => true, 'layer_id' => null, 'sld' => $sld, 'layerType' => null, 'layer_name' => null, 'data' => $spatial));
    }

}
