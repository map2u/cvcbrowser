<?php

namespace Map2u\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * map2u_core controller.
 *
 * @Route("/map2uweb")
 */
class DefaultController extends Controller {

  public function indexAction(Request $request) {
    $lat = null;
    $lng = null;
    $IP_ADDR = $request->getClientIp();
    $geoip = $this->get('maxmind.geoip')->lookup($IP_ADDR);
    /*        $geoip->getCountryCode();
      $geoip->getCountryCode3();
      $geoip->getCountryName();
      $geoip->getRegion();
      $geoip->getCity();
      $geoip->getPostalCode();
     *
     */ if ($geoip) {
      $lat = $geoip->getLatitude();
      $lng = $geoip->getLongitude();
    }
    //       $geoip->getAreaCode();
//        $geoip->getMetroCode();
//        $geoip->getContinentCode();

    return $this->render('Map2uWebBundle:Default:index.html.twig');
  }

  public function leafletmapAction(Request $request) {
    return $this->render('Map2uWebBundle:Default:leafletmap.html.twig');
  }

  /**
   *
   * @Route("/map", name="map2uweb_map")
   * @Method("GET")
   * @Template()
   */
  public function mapAction(Request $request) {
    $lat = null;
    $lng = null;
    $IP_ADDR = $request->getClientIp();
    //     $geoip = $this->get('maxmind.geoip')->lookup($IP_ADDR);
    /*        $geoip->getCountryCode();
      $geoip->getCountryCode3();
      $geoip->getCountryName();
      $geoip->getRegion();
      $geoip->getCity();
      $geoip->getPostalCode();
     *
      // */ //if ($geoip) {
//            $lat = $geoip->getLatitude();
//            $lng = $geoip->getLongitude();
//        }
    //       $geoip->getAreaCode();
//        $geoip->getMetroCode();
//        $geoip->getContinentCode();

    $em = $this->getDoctrine()->getManager();
    $stations = $em->getRepository("YorkuJuturnaBundle:Station")->findAll();
    if ($this->getUser()) {
      $custom_geometries = $em->getRepository("YorkuJuturnaBundle:TourismGeoms")->findBy(array('user' => $this->getUser()));
    }
    else {
      $custom_geometries = null;
    }
    return $this->render('Map2uWebBundle:Default:map.html.twig', array("stations" => $stations, 'custom_geometries' => $custom_geometries));
    //      return $this->render('Map2uWebBundle:Default:map.html.twig', array('lat' => $lat, 'lng' => $lng));
  }

  /**
   *
   * @Route("/savegeometries", name="map2uweb_savegeometries")
   * @Method("GET|POST")
   * @Template()
   */
  public function savegeometriesAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $userid = $request->get('userid');
    $overwrite = $request->get('overwrite');
    $geometries = $request->get('geometries');
    $geom=new  \Yorku\JuturnaBundle\Entity\TourismGeoms();
    $geom->setCode("test");
    $geom->setName('name');
//    $geom->setUser($this->getUser());
//    $geom->setGeomCollect($geometries);
    $em->persist($geom);
    $em->flush();
    return new JsonResponse(array('success' => false, 'data' => $geometries));
  }

  /**
   *
   * @Route("/getgeometries", name="map2uweb_getgeometries")
   * @Method("GET")
   * @Template()
   */
  public function getgeometriesAction(Request $request) {
    $id= $request->get("id");
    if(isset($id) && strlen($id)>0)
    {
       $conn = $this->get('database_connection');
     $geometries = $conn->fetchAll("select id, name,st_astext(the_geom) as the_geom  from user_tourism_geoms where id=" . $id );
      return new JsonResponse(array('success' => true, 'data' => $geometries[0]));
    }
    return new JsonResponse(array('success' => false, 'data' => null));
  }

  /**
   *
   * @Route("/getgeometrylist", name="map2uweb_getgeometrylist")
   * @Method("GET")
   * @Template()
   */
  public function getgeometrylistAction(Request $request) {

    if ($this->getUser()) {
      $conn = $this->get('database_connection');
      $geometries = $conn->fetchAll("select id, user_id, name  from user_tourism_geoms where user_id=" . $this->getUser()->getId() . " or is_published=true order by name");
 //     $geometries = $conn->fetchAll("select id, user_id, name, created_at,updated_at  from user_tourism_geoms where user_id=" . $this->getUser()->getId() . " or is_published=true order by name");
      return new JsonResponse(array('success' => true, 'data' => $geometries));
    }
    return new JsonResponse(array('success' => true, 'data' => null));
  }
}
