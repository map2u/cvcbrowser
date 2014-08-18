<?php

namespace Application\Map2u\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Map2u\CoreBundle\Entity\UploadShapefileLayer;
use Application\Map2u\CoreBundle\Entity\UserDrawGeometries;

/**
 * Welcome controller.
 *
 * @Route("/draw")
 */
class DrawController extends Controller {

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/polyline", name="draw_polyline", options={"expose"=true})
   * @Method("GET|POST")
   * @Template()
   */
  public function polylineAction() {
    $request = $this->getRequest();
    $index = $request->get('index');
    $id = $request->get('id');
    $name = $request->get('name');
    $radius = $request->get('radius');
    $usergeometries = $this->getUserDrawGeometries($id);
    return array('id' => $id, 'index' => $index, 'usergeometry' => $usergeometries, 'name' => $name, 'radius' => $radius);
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/polygon", name="draw_polygon", options={"expose"=true})
   * @Method("GET|POST")
   * @Template()
   */
  public function polygonAction() {
    $request = $this->getRequest();
    $index = $request->get('index');
    $id = $request->get('id');
    $name = $request->get('name');
    $radius = $request->get('radius');

    $usergeometries = $this->getUserDrawGeometries($id);
    return array('id' => $id, 'index' => $index, 'usergeometry' => $usergeometries, 'name' => $name, 'radius' => $radius);
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/rectangle", name="draw_rectangle", options={"expose"=true})
   * @Method("GET|POST")
   * @Template()
   */
  public function rectangleAction() {
    $request = $this->getRequest();
    $index = $request->get('index');
    $id = $request->get('id');
    $name = $request->get('name');
    $radius = $request->get('radius');

    $usergeometries = $this->getUserDrawGeometries($id);
    return array('id' => $id, 'index' => $index, 'usergeometry' => $usergeometries, 'name' => $name, 'radius' => $radius);
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/circle", name="draw_circle", options={"expose"=true})
   * @Method("GET|POST")
   * @Template()
   */
  public function circleAction() {
    $request = $this->getRequest();
    $index = $request->get('index');
    $id = $request->get('id');
    $name = $request->get('name');
    $radius = $request->get('radius');

    $usergeometries = $this->getUserDrawGeometries($id);
    return array('id' => $id, 'index' => $index, 'usergeometry' => $usergeometries, 'name' => $name, 'radius' => $radius);
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/marker", name="draw_marker", options={"expose"=true})
   * @Method("GET|POST")
   * @Template()
   */
  public function markerAction() {

    $markers = array();
    $user = $this->getUser();
    $icon_path = $this->get('kernel')->getRootDir() . '/../web/images/markers';
    if ($user) {
      foreach (glob($icon_path . '/' . $user->getId() . '/*.*') as $file) {
        $file1 = substr($file, 0, strrpos($file, '/', -1));
        $file2 = substr($file, 0, strrpos($file1, '/', -1));
        $markers[substr($file, strlen($file2) + 1)] = substr($file, strlen($file2) + 1);
      }
    }
    foreach (glob($icon_path . '/*.*') as $file) {
      $markers[substr($file, strrpos($file, '/', -1) + 1)] = substr($file, strrpos($file, '/', -1) + 1);
    }

    $request = $this->getRequest();
    $index = $request->get('index');
    $id = $request->get('id');
    $name = $request->get('name');

    $usergeometries = $this->getUserDrawGeometries($id);

    $radius = $request->get('radius');
    return array('id' => $id, 'index' => $index, 'usergeometry' => $usergeometries, 'name' => $name, 'radius' => $radius, 'markers' => $markers);
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/save", name="draw_save", options={"expose"=true})
   * @Method("GET|POST")
   * @Template()
   */
  public function saveAction() {

    $upload_path = $this->get('kernel')->getRootDir() . '/../web/uploads';
    $user = $this->getUser();
    if (!isset($user) || empty($user)) {
      return new Response(\json_encode(array('success' => false, 'message' => 'Must be a logged in user!')));
    }
    $request = $this->getRequest();
    $id = $request->get('id');
    $drawname = $request->get('name');
    $feature = json_decode($request->get('feature'), true);
    $drawradius = $request->get('radius');
    $drawtype = $request->get('type');
    $drawbuffer = $request->get('buffer');
    $description = $request->get('description');
    $selected_marker = $request->get('select_marker');
    $upload_marker_icon = $request->files->get('upload_marker_icon');
    $upload_images = $request->files->get('images');
    $upload_video = $request->files->get('video');
    $upload_audio = $request->files->get('audio');

    $update_geom = false;
    $em = $this->getDoctrine()->getManager();
//    if (!isset($id)) {
//      return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
//    }
    if ((!isset($id))||((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined')))) {
      $usergeometries = new UserDrawGeometries();
      $usergeometries->setUserId($user->getId());
      $usergeometries->setName($drawname);
      $em->persist($usergeometries);
      $em->flush();
    }
    else {
      $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->find($id);
      $update_geom = true;
    }
    if ($usergeometries) {
      $usergeometries->setUserId($user->getId());
      //    $usergeometries->setUserId(1);
      $usergeometries->setName($drawname);
      if (isset($description)) {
        $usergeometries->setDescription($description);
      }

      if ($upload_images) {
        if (!file_exists($upload_path . "/images/" . $user->getId())) {
          mkdir($upload_path . "/images/" . $user->getId(), 0755, true);
        }
        if (is_array($upload_images)) {
          $images = array();
          foreach ($upload_images as $upload_image) {
            if ($upload_image !== null) {
              move_uploaded_file($upload_image->getPathname(), $upload_path . "/images/" . $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_image->getClientOriginalName());
              array_push($images, $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_image->getClientOriginalName());
            }
          }
          if (count($images) > 0)
            $usergeometries->setImages(serialize($images));
        }
        else {
          move_uploaded_file($upload_images->getPathname(), $upload_path . "/images/" . $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_images->getClientOriginalName());
          $images = $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_images->getClientOriginalName();
          $usergeometries->setImages($images);
        }
      }
      if ($upload_video) {
        if (!file_exists($upload_path . "/videos/" . $user->getId())) {
          mkdir($upload_path . "/videos/" . $user->getId(), 0755, true);
        }

        move_uploaded_file($upload_video->getPathname(), $upload_path . "/videos/" . $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_video->getClientOriginalName());
        $video = $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_video->getClientOriginalName();
        $usergeometries->setVideo($video);
      }
      if ($upload_audio) {
        if (!file_exists($upload_path . "/audios/" . $user->getId())) {
          mkdir($upload_path . "/audios/" . $user->getId(), 0755, true);
        }

        move_uploaded_file($upload_audio->getPathname(), $upload_path . "/audios/" . $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_audio->getClientOriginalName());
        $audio = $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_audio->getClientOriginalName();
        $usergeometries->setAudio($audio);
      }
      if ($upload_marker_icon) {
        if (!file_exists($upload_path . "/images/markers")) {
          mkdir($upload_path . "/images/markers", 0755, true);
        }
        if (!file_exists($upload_path . "/images/markers/" . $user->getId())) {
          mkdir($upload_path . "/images/markers/" . $user->getId(), 0755, true);
        }
        move_uploaded_file($upload_marker_icon->getPathname(), $upload_path . "/images/markers/" . $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_marker_icon->getClientOriginalName());
        $selected_marker = 'images/markers/' . $user->getId() . "/" . $usergeometries->getId() . '_' . $upload_sldfile->getClientOriginalName();
        $usergeometries->setMarkerIcon($selected_marker);
      }
      else {
        if (isset($selected_marker)) {
          $usergeometries->setMarkerIcon($selected_marker);
        }
      }

      //   $usergeometries->setDescription($description);
      $usergeometries->setGeomType($drawtype);
      $usergeometries->setRadius($drawradius);
      $usergeometries->setBuffer($drawbuffer);
      $em->persist($usergeometries);
      $em->flush();
      $usergeometries_id = $usergeometries->getId();

      $conn = $this->get('database_connection');
      $feature_geojson = $feature['geometry'];
      if ($drawtype === 'circle' || $drawtype === 'marker') {
        $lng = $feature['geometry']['coordinates'][0];
        $lat = $feature['geometry']['coordinates'][1];
        if ($update_geom === true) {
          $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('POINT($lng $lat)', 4326) where userdrawgeometries_id=$usergeometries_id";
        }
        else {

          //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, st_geomfromgeojson('$feature_geojson'))";
          $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, ST_GeomFromText('POINT($lng $lat)', 4326))";
        }
      }
      if ($drawtype === 'rectangle' || $drawtype === 'polygon') {
        $points = '';
        // var_dump(count($feature['geometry']['coordinates'][0]));

        foreach ($feature['geometry']['coordinates'][0] as $point) {

          if ($points === '') {
            $points = "$point[0]  $point[1]";
          }
          else {
            $points = $points . ",$point[0]  $point[1]";
          }
        }
        if ($update_geom === true) {
          $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('POLYGON(($points))', 4326) where userdrawgeometries_id=$usergeometries_id";
        }
        else {
          //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, st_geomfromgeojson('$feature_geojson'))";
          $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, ST_GeomFromText('POLYGON(($points))', 4326))";
        }
      }
      if ($drawtype === 'polyline') {
        $points = '';
        //    var_dump(count($feature['geometry']['coordinates']));
        //        var_dump($feature['geometry']['coordinates']);
        foreach ($feature['geometry']['coordinates'] as $point) {

          if ($points === '') {
            $points = "$point[0]  $point[1]";
          }
          else {
            $points = $points . ",$point[0]  $point[1]";
          }
        }
        if ($update_geom === true) {
          $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('LINESTRING($points)', 4326) where userdrawgeometries_id=$usergeometries_id";
        }
        else {

          //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, st_geomfromgeojson('$feature_geojson'))";
          $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, ST_GeomFromText('LINESTRING($points)', 4326))";
        }
      }
      $stmt = $conn->query($sql);
      // $response = new JsonResponse(array('success' => true, 'data' => $stmt));

      return new Response(\json_encode(array('success' => true, 'id' => $usergeometries_id)));
    }
    else {
      return new Response(\json_encode(array('success' => false, 'id' => $usergeometries_id, 'message' => 'User draw geometry id:' . $usergeometries_id . ' not found!')));
    }


    // st_geomfromgeojson (text)?

    return new Response(\json_encode(array('success' => false)));
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/update", name="draw_update", options={"expose"=true})
   * @Method("GET|POST")
   * @Template()
   */
  public function updateAction() {
    return array();
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/delete", name="draw_delete", options={"expose"=true})
   * @Method("POST")
   * @Template()
   */
  public function deleteAction() {

    $user = $this->getUser();
    if (!isset($user) || empty($user)) {
      return new Response(\json_encode(array('success' => false, 'message' => 'Must be a logged in user!')));
    }
    $request = $this->getRequest();
    $id = $request->get('id');

    $em = $this->getDoctrine()->getManager();
    if (!isset($id)) {
      return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
    }

    $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->find($id);
    if ($usergeometries) {
      $em->remove($usergeometries);
      $em->flush();
      return new Response(\json_encode(array('success' => true, 'message' => 'successfully deleted!')));
    }
    else {
      return new Response(\json_encode(array('success' => false, 'message' => 'ID:' . $id . ' user draw geometry not found!')));
    }
  }

  private function getUserDrawGeometries($id) {
    $em = $this->getDoctrine()->getManager();
    if (isset($id) && $id > 0) {
      $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->find($id);
    }
    else {
      $usergeometries = null;
    }
    return $usergeometries;
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/drawcontent", name="draw_content", options={"expose"=true})
   * @Method("GET")
   * @Template()
   */
  public function drawcontentAction() {


    $request = $this->getRequest();
    $id = $request->get('id');

    $em = $this->getDoctrine()->getManager();
    if (!isset($id)) {
      return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
    }

    $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->find($id);
    if ($usergeometries) {

      return array('success' => true, 'usergeometries' => $usergeometries, 'message' => 'successfully deleted!');
    }
    else {
      return new Response(\json_encode(array('success' => false, 'usergeometries' => null, 'message' => 'ID:' . $id . ' user draw geometry not found!')));
    }
  }

}
