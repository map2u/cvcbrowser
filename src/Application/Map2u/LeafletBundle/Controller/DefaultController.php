<?php

namespace Application\Map2u\LeafletBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Map2u\LeafletBundle\Controller\DefaultController as BaseController;

/**
 * Map2u Core Default controller.
 *
 * @Route("/leaflet")
 */
class DefaultController extends BaseController {

    /**
     * .
     *
     * @Route("/map", name="appleaflet_map")
     * @Method("GET")
     * @Template()
     */
    public function mapAction(Request $request) {

        $view = $request->get("view");
        $id = $request->get("id");
        return array('view' => $view, 'id' => $id); //$this->render('Map2uLeafletBundle:Default:map.html.twig',{'view'=>$view});
    }

    /**
     * .
     *
     * @Route("/storylayers", name="appleaflet_storylayer", options={"expose"=true})
     * @Method("GET")

     */
    public function storylayersAction(Request $request) {
        $conn = $this->get('database_connection');
        $sql = "select id, story_name, image_file,story_file, st_x(ST_Centroid(the_geom)) as lng,st_y(ST_Centroid(the_geom)) as lat  from stories";
        $results = $conn->fetchAll($sql);
        for ($i = 0; $i < count($results); $i++) {
            $results[$i]['image_file'] = unserialize($results[$i]['image_file']);
        }
        return new JsonResponse(array('success' => true, "stories" => $results)); //$this->render('Map2uLeafletBundle:Default:map.html.twig',{'view'=>$view});
    }

}
