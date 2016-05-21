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
            if ($layer->getSldFileName() !== '' && $layer->getSldFileName() !== null) {
                $sld = DefaultMethods::getSldContent($this, $layer->getSldFileName());
            }

            return new JsonResponse(array('success' => true, 'layerType' => $layer->getLayerType(), 'sld' => $sld, 'layer_id' => $layer->getId(), 'layer_name' => $layer->getName(), 'layer_property' => json_decode($layer->getLayerProperty()), 'data' => $spatial));
        }
        return new JsonResponse(array('success' => true, 'layer_id' => null, 'sld' => $sld, 'layerType' => null, 'layer_name' => null, 'data' => $spatial));
    }
    
}
