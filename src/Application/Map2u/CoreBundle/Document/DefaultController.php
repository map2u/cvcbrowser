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
use Map2u\CoreBundle\Entity\UserUploadShapefile;
use Map2u\CoreBundle\Entity\UserUploadShapefileGeom;

/**
 * Map2u Core Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller {

  /**
   * Welcome controller.
   *
   * @Route("/map2ucoreindex" , name="map2ucore_index")
   */
  public function indexAction($name) {
    return $this->render('Map2uCoreBundle:Default:index.html.twig', array('name' => $name));
  }

  /**
   * Welcome controller.
   *
   * @Route("/latestnews" , name="map2ucore_latestnews")
   */
  public function latestnewsAction() {
    return $this->render('Map2uCoreBundle:Default:latestnews.html.twig');
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/checkuserdrawname", name="default_checkuserdraw_name", options={"expose"=true})
   * @Method("GET")
   * @Template()
   */
  public function checkuserdrawnameAction() {
    $request = $this->getRequest();
    $user = $this->getUser();
    if (!isset($user) || empty($user)) {
      return new Response(\json_encode(array('success' => false, 'message' => 'Must be a logged in user!')));
    }
    $drawname = $request->get('name');
    if (!isset($drawname) || empty($drawname)) {
      return new Response(\json_encode(array('success' => false, 'message' => 'Name can not be empty!')));
    }
    $em = $this->getDoctrine()->getManager();

    $usergeometries = $em->getRepository('Map2uCoreBundle:UserDrawGeometries')->find(array('userId' => $user->getId(), 'name' => $drawname));
    if ($usergeometries) {
      return new Response(\json_encode(array('success' => false, 'message' => 'User draw name ' . $drawname . ' already exist')));
    }
    return new Response(\json_encode(array('success' => true, 'message' => 'User draw name ' . $drawname . ' not exist')));
  }

  /**
   * get feature extend.
   * params: ogc_fid and userboundary_id
   * @Route("/saveuserdraw", name="default_saveuserdraw_geom", options={"expose"=true})
   * @Method("GET|POST")
   * @Template()
   */
  public function saveuserdrawAction() {
    $request = $this->getRequest();
    $id = $request->get('id');
    $drawname = $request->get('name');
    $drawtype = $request->get('type');
    $drawpoints = $request->get('points');
    $drawradius = $request->get('radius');
    $drawbuffer = $request->get('buffer');

    $user = $this->getUser();

    if (!isset($user) || empty($user)) {
      return new Response(\json_encode(array('success' => false, 'data' => 'Must be a logged in user!')));
    }
//    if (!isset($id) || empty($id)) {
//      return new Response(\json_encode(array('success' => false, 'data' => 'No valid Layer ID')));
//    }

    $em = $this->getDoctrine()->getManager();
    if (isset($id) || $id === 0) {
      $usergeometries = new Map2u\CoreBundle\Entity\UserDrawGeometries();
    }
    else {
      $usergeometries = $em->getRepository('Map2uCoreBundle:UserDrawGeometries')->find($id);
    }
    if ($usergeometries) {
      $usergeometries->setUserId($user->getId());
      $usergeometries->setName($drawname);
      $usergeometries->setGeomType($drawtype);
      $usergeometries->setRadius($drawradius);
      $usergeometries->setBuffer($drawbuffer);
      $em->persist($usergeometries);
      $em->flush();
      $usergeometries_id = $usergeometries->getId();
      $usergeometriesgeom = $em->getRepository('Map2uCoreBundle:UserDrawGeometriesGeom')->find(array('userdrawgeometries_id' => $usergeometries_id));
      if (!$usergeometriesgeom) {
        $usergeometriesgeom = new Map2u\CoreBundle\Entity\UserDrawGeometriesGeom();
      }
      $usergeometriesgeom->setUserdrawgeometries($usergeometries);

      if ($drawtype === 'circle') {
        $thegeom = new Point();
        //$thegeom->
      }
      $usergeometriesgeom->setGeom();
    }





    $userboundary_id = $request->get("userboundary_id");
    $ogc_fid = $request->get("ogc_fid");
    $data = array();
    $conn = $this->get('database_connection');

    $sql = "SELECT st_srid(the_geom) as srid , box(the_geom) as bounds, st_astext(st_centroid(the_geom)) as the_geom FROM manifold_geoms WHERE userboundary_id=" . $userboundary_id . ' and ogc_fid=' . $ogc_fid;
    $stmt = $conn->fetchAll($sql);
    $response = new JsonResponse(array('success' => true, 'data' => $stmt));
    return $response;
  }

  /**
   *
   * @Route("/layergeomjson" , name="default_getlayergeomjson")
   * @Method({"GET"})
   */
  public function layergeomjsonAction() {
    $request = $this->getRequest();
    $id = $request->get('id');
    $user = $this->getUser();

    if (!isset($user) || empty($user)) {
      return new Response(\json_encode(array('success' => false, 'data' => 'Must be a logged in user!')));
    }
    if (!isset($id) || empty($id)) {
      return new Response(\json_encode(array('success' => false, 'data' => 'No valid Layer ID')));
    }
    $em = $this->getDoctrine()->getManager();
    $layer = $em->getRepository('Map2uCoreBundle:UploadShapefileLayer')->find($id);
    if (!$layer) {
      return new Response(\json_encode(array('success' => false, 'data' => 'Layer not found by id:' . $id)));
    }
    $useruploadshapefile = $layer->getUseruploadshapefile();
    if (!$useruploadshapefile) {
      return new Response(\json_encode(array('success' => false, 'data' => 'Layer data not found by id:' . $id)));
    }
    $topojsonfilename = $useruploadshapefile->getTopojsonfileName();
    if (($layer->getTopojsonOnly() == true) && (is_null($topojsonfilename) != true) && (empty($topojsonfilename) != true)) {

      return new Response(\json_encode(array('success' => true, 'type' => 'topojsonfile', 'data' => '/uploads/shapefiles/' . $user->getId() . '/u' . $useruploadshapefile->getId() . '_' . $useruploadshapefile->getTopojsonfileName())));
    }

    $conn = $this->get('database_connection');
    $sql = 'select st_asgeojson(the_geom4326,4) as the_geom from ' . $useruploadshapefile->getGeomtableName();
    $result = $conn->fetchAll($sql);
    return new Response(\json_encode(array('success' => true, 'type' => 'geojson', 'data' => $result)));
  }

  /**
   * Welcome controller.
   *
   * @Route("/uploadshapefile" , name="default_uploadshapefile")
   * @Method({"POST"})
   */
  public function uploadshapefileAction() {
    // get current url and save it to twig global variables as currentUrl

    $form = $this->createFormBuilder()
        ->add('shapefileupload_name', 'text', array('label' => 'Boundary Name :', 'attr' => array("placeholder" => "Input a boundary name!", "onchange" => "shapefileUploadFormValidation(false)")
        ))
        ->add('epsg_name', 'text', array('label' => 'EPSG Code:', 'required' => false, 'attr' => array("placeholder" => "Input a shape file EPSG Code!", "onchange" => "shapefileUploadFormValidation(false)")
        ))
        ->add('shape_file', 'file', array('label' => 'Shape File(*.shp):', 'attr' => array('multiple' => true, 'onchange' => 'select_readdbf_file();')
        ))
        ->add('boundary_name_field', 'choice', array('read_only' => true, 'required' => true, 'label' => 'Label Field :', 'attr' => array("onchange" => "boundary_name_field_changed(this.value)")))
        ->add('boundary_name_field2', 'hidden')
        ->add('upload_file_list', 'choice', array('virtual' => true, 'mapped' => false, 'label' => 'Upload File List:', 'attr' => array('onDblClick' => 'uploadFileListDblClick(this.value);', 'size' => "4", "placeholder" => "upload file list!")))
        ->add('projection', 'choice', array('label' => 'Projection :', 'empty_data' => null, 'expanded' => true, 'choices' => array('1' => 'WGS84(EPSG:4326)', '2' => "NAD1983(EPSG:4269)", '0' => 'EPSG Code'),
          "attr" => array("onchange" => "shapefileUploadFormValidation(false)"
          )
        ))
        ->getForm();

    $em = $this->getDoctrine()->getManager();

    // get request  and check if the form post or not
    $request = $this->getRequest();
    $session = $request->getSession();
    $action = '';
    $user = $this->getUser();
    if (!$user) {
      return new Response(\json_encode(array('success' => false, 'message' => 'Only logged in user can upload shape file to server')));
    }

    $ip = $request->getClientIp();

    if ($request->getMethod() !== "POST") {
      return new Response(\json_encode(array('success' => false, 'message' => 'Only post method will be used here for uploading shape file to server')));
      //     return $this->redirect($url);
    }
    $form->handleRequest($request);
    if ($form->isSubmitted()) {
      $path = getenv('PATH');
      putenv("PATH=$path:/opt/local/bin");

      $data_path = $this->get('kernel')->getRootDir() . '/../Data';

      $data = $form->getData();
      $epsgnumber = 0;
      $shp_file = null;
      $dbf_file = null;
      $shx_file = null;
      $prj_file = null;
      $shpTablename = '';
      $dir = $data_path . '/shapefiles/' . $this->getUser()->getId();

      if ($data['shape_file'] != null) {

        $shpfiles = $data['shape_file'];
        if (is_array($shpfiles)) {



          foreach ($shpfiles as $file) {
            $filename = $file->getClientOriginalName();
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.shp') {
              $shp_file = $file;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.dbf') {
              $dbf_file = $file;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.shx') {
              $shx_file = $file;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.prj') {
              $prj_file = $file;
            }
          }
        }

        if ($shx_file === null || $dbf_file === null || $shp_file === null) {
          return new Response(\json_encode(array('success' => false, 'message' => 'Missing file (.shp or .dbf or shx)')));
        }


        if ($prj_file === null) {

          $projection = $data['projection'];
          if ($projection === 1) {
            $epsgnumber = 4326;
          }
          if ($projection === 2) {
            $epsgnumber = 4269;
          }
          if ($projection === 0) {
            $epsgnumber = $data['epsg_name'];
          }
          if ($epsgnumber === 0) {
            return new Response(\json_encode(array('success' => false, 'message' => 'No valid EPSG numer or projection file defined')));
          }
        }




        $useruploadshapefile = $em->getRepository('Map2uCoreBundle:UserUploadShapefile')->findOneBy(array('userId' => $user->getId(), 'shapefileName' => $shp_file->getClientOriginalName()));
        if ($useruploadshapefile === null) {
          $action = 'createnew';
          $useruploadshapefile = new \Map2u\CoreBundle\Entity\UserUploadShapefile();
          //     $useruploadshapefile->setProjection("EPSG:4326");
          $useruploadshapefile->setSessionId($session->getId());
          $useruploadshapefile->setShapefileName($shp_file->getClientOriginalName());
          //      $useruploadshapefile->setTopojsonfileName($topojsonfileName);
          $useruploadshapefile->setUserId($user->getId());
          $em->persist($useruploadshapefile);
          $em->flush();
        }
        else {
          $action = 'update';
          $useruploadshapefile->setSessionId($session->getId());
          $em->persist($useruploadshapefile);
          $em->flush();
        }
        $shpTablename = "useruploadshapefile_geoms_" . $useruploadshapefile->getId();



        if ($prj_file !== null) {
          $prj_file->move($dir, 'u' . $useruploadshapefile->getId() . '_' . str_replace(' ', '-', trim($prj_file->getClientOriginalName())));
        }

        if ($shx_file !== null) {
          $shp_file->move($dir, 'u' . $useruploadshapefile->getId() . '_' . str_replace(' ', '-', trim($shp_file->getClientOriginalName())));
          if ($shx_file !== null) {
            $shx_file->move($dir, 'u' . $useruploadshapefile->getId() . '_' . str_replace(' ', '-', trim($shx_file->getClientOriginalName())));
          }
          if ($dbf_file) {
            $dbf_file->move($dir, 'u' . $useruploadshapefile->getId() . '_' . str_replace(' ', '-', trim($dbf_file->getClientOriginalName())));
          }
          $conn = $this->get('database_connection');
          $shpDbname = $conn->getDatabase();
          if ($prj_file !== null) {

            $output = shell_exec('ogr2ogr -overwrite -unsetFieldWidth -f "PostgreSQL" PG:"host=127.0.0.1 user=jzhao dbname=' . $shpDbname . ' password=jzhao" -nlt GEOMETRY -t_srs EPSG:4326  -lco GEOMETRY_NAME=the_geom -nln ' . $shpTablename . ' ' . $dir . '/' . 'u' . $useruploadshapefile->getId() . '_' . str_replace(' ', '-', trim($shp_file->getClientOriginalName())));
            //      $output = shell_exec('ogr2ogr -overwrite -t_srs EPSG:4326 '. $dir. '/usershapefile-'.$useruploadshapefile->getId() .'.shp ' . $dir . '/' . 'u' . $useruploadshapefile->getId() . '_' . $shp_file->getClientOriginalName());
            // -a_srs http://spatialreference.org/ref/epsg/4326/ -t_srs http://spatialreference.org/ref/epsg/26915
var_dump($output);
            }
          else {
            if ($epsgnumber !== 0) {

              $output = shell_exec('ogr2ogr -overwrite -unsetFieldWidth -f "PostgreSQL" PG:"host=127.0.0.1 user=jzhao dbname=' . $shpDbname . ' password=jzhao" -nlt GEOMETRY -t_srs EPSG:4326 -a_srs EPSG:' . $epsgnumber . ' -lco GEOMETRY_NAME=the_geom -nln ' . $shpTablename . ' ' . $dir . '/' . 'u' . $useruploadshapefile->getId() . '_' . str_replace(' ', '-', trim($shp_file->getClientOriginalName())));

              //      echo 'ogr2ogr -overwrite -t_srs EPSG:4326 -a_srs EPSG:' . $epsgnumber .' '. $dir. '/usershapefile-'.$useruploadshapefile->getId() .'.shp ' . $dir . '/' . 'u' . $useruploadshapefile->getId() . '_' . $shp_file->getClientOriginalName();
              //       $output = shell_exec('ogr2ogr -overwrite -t_srs EPSG:4326 -a_srs EPSG:' . $epsgnumber .' '. $dir. '/usershapefile-'.$useruploadshapefile->getId() .'.shp ' . $dir . '/' . 'u' . $useruploadshapefile->getId() . '_' . $shp_file->getClientOriginalName());
                     var_dump($output);
            }
          }

          $sql = "SELECT AddGeometryColumn('" . $shpTablename . "','the_geom4326',4326, 'GEOMETRY', 2)";
          $stmt = $conn->query($sql);
          //    $sql = 'update ' . $shpTablename . ' set the_geom4326=st_transform(the_geom,4326)';
          //    $stmt = $conn->query($sql);


          $sql = "SELECT column_name FROM information_schema.columns WHERE table_name='" . $shpTablename . "'";
          $stmt = $conn->fetchAll($sql);

          $rowCount = count($stmt);
          $column_name_array = array();
          for ($i = 0; $i < $rowCount; $i++) {
            if ($stmt[$i]['column_name'] === 'the_geom' || $stmt[$i]['column_name'] === 'geom' || $stmt[$i]['column_name'] === 'the_geom4326') {
              unset($stmt[$i]);
            }
            else {
              array_push($column_name_array, $stmt[$i]['column_name']);
            }
            //   return new Response(\json_encode(array('success' => false, 'data' => 'label Field:' . strtolower($data['boundary_name_field2']) . ' not exist')));
          };


          $column_names = implode(',', $column_name_array);


          $geom_column = "the_geom";

          $sql = "select box(the_geom) from " . $shpTablename . " LIMIT 1";
          $stmt = $conn->fetchAll($sql);
          if (isset($stmt[0]) && is_array($stmt)) {
            $boxdata = $stmt[0]['box'];
            $boxdata = preg_replace("/[^0-9,.]/", "", $boxdata);
            $boxarray = explode(",", $boxdata);
            if (floatval($boxarray[0]) > 180.0 || floatval($boxarray[0]) < -180) {
              $geom_column = "the_geom4326";
              $sql = 'update ' . $shpTablename . ' set the_geom4326=st_transform(the_geom,4326)';
              $stmt = $conn->query($sql);
            }
          }
          //         $topojsonfileName = 'u' . $useruploadshapefile->getId() . '_' . substr_replace($shp_file->getClientOriginalName(), '', -4) . '.json';
          $topojsonfileName = 'usershapefile-' . $useruploadshapefile->getId() . '.json';

          //         $output = shell_exec('topojson -o ' . $dir . '/' . $topojsonfileName . ' -p ' . $data['boundary_name_field2'] . ' ' . $dir . '/u' . $useruploadshapefile->getId() . '_' . $shp_file->getClientOriginalName() . ' 2>&1');
          //     echo 'topojson -o ' . $dir . '/' . $topojsonfileName . ' -p ' . $data['boundary_name_field2'] . ' ' . $dir . '/usershapefile-'.$useruploadshapefile->getId() .'.shp ' . ' 2>&1';
          $sql2shapefile = 'ogr2ogr -overwrite -unsetFieldWidth -f "ESRI Shapefile" ' . $dir . '/usershapefile-' . $useruploadshapefile->getId() . '.shp PG:"host=127.0.0.1 user=jzhao dbname=' . $shpDbname . ' password=jzhao" -sql "SELECT ogc_fid as ogc_id,' . $column_names . ',' . $geom_column . ' as the_geom FROM ' . $shpTablename . '" 2>&1';
//echo $sql2shapefile;

          $output = shell_exec($sql2shapefile);
//var_dump($output);
          $topojsonfile = 'topojson -p -o ' . $dir . '/' . $topojsonfileName . '  ' . $dir . '/usershapefile-' . $useruploadshapefile->getId() . '.shp ' . ' 2>&1';
//echo $topojsonfile;
//          $output = shell_exec('which topojson');
//var_dump($output);
//          $output = shell_exec('env');
//var_dump($output);
          $output = shell_exec($topojsonfile);
//var_dump($output);
          $sql = 'DELETE from useruploadshapefile_geoms where useruploadshapefile_id = ' . $useruploadshapefile->getId();
          $stmt = $conn->query($sql);

          $sql = 'INSERT into useruploadshapefile_geoms (useruploadshapefile_id,ogc_fid,geometry_type, created_at,updated_at) ( select ' . $useruploadshapefile->getId() . ',ogc_fid,GeometryType(the_geom4326),now(),now() from ' . $shpTablename . ')';
          $stmt = $conn->query($sql);

          // update geometry table name and geometry field name
          $useruploadshapefile->setTopojsonfileName($topojsonfileName);
          $useruploadshapefile->setGeomFieldName('the_geom4326');
          $em->persist($useruploadshapefile);
          $em->flush();


          return new Response(\json_encode(array('success' => true, 'action' => $action, 'data' => array('shapefile' => array('id' => $useruploadshapefile->getId(), 'shapefilename' => $useruploadshapefile->getShapefileName(), 'updated_at' => $useruploadshapefile->getUpdatedAt()), 'shapefile_topojson_url' => $this->generateUrl('default_shapefile_topojson'), 'shapefile_delete_url' => $this->generateUrl("default_shapefile_delete")), 'message' => 'Successfully uploaded shapfile:' . $shp_file->getClientOriginalName())));
        }
        return new Response(\json_encode(array('success' => false, 'data' => array(), 'message' => 'Something wrong with uploaded shapfile:' . $shp_file->getClientOriginalName())));
      }
    }
  }

  /**
   * Welcome controller.
   *
   * @Route("/shapefile_settings" , name="default_shapefile_settings",options={"expose"=true})
   * @Method({"GET|POST"})
   * @Template()
   */
  public function shapefile_settingsAction() {
    $request = $this->getRequest();
    $id = $request->get('id');
    $user = $this->getUser();


    $sld_path = $this->get('kernel')->getRootDir() . '/../Data';

    $sld_files = array();
    foreach (glob($sld_path . '/sld/' . $user->getId() . '/*.sld') as $file) {
      $file1 = substr($file, 0, strrpos($file, '/', -1));
      $file2 = substr($file, 0, strrpos($file1, '/', -1));
      $sld_files[substr($file, strlen($file2) + 1)] = substr($file, strlen($file2) + 1);
    }

    foreach (glob($sld_path . '/sld/*.sld') as $file) {
      $sld_files[substr($file, strrpos($file, '/', -1) + 1)] = substr($file, strrpos($file, '/', -1) + 1);
    }

    $em = $this->getDoctrine()->getManager();
    $useruploadshapefile = $em->getRepository('Map2uCoreBundle:UserUploadShapefile')->findOneBy(array('id' => $id));

    if ($request->getMethod() === "POST") {


      $select_sldfile = $request->get('select_sld_file');
      $select_labelfile = $request->get('select_label_field');
      $select_tipfield = $request->get('select_tip_field');

      $upload_sldfile = $request->files->get('upload_sld_file');
      if ($upload_sldfile && $upload_sldfile->getPathname()) {
        if (is_numeric($upload_sldfile->getClientOriginalName())) {
          return new Response(\json_encode(array('success' => false, 'message' => 'SLD file name can not be numberic!')));
        }
        $info = pathinfo($upload_sldfile->getClientOriginalName());
        // var_dump($info);
        if ($info["extension"] !== "sld") {
          return new Response(\json_encode(array('success' => false, 'message' => "SLD file name extension name must be '.sld' !")));
        }
        if (!file_exists($sld_path . "/sld/" . $user->getId())) {
          mkdir($sld_path . "/sld/" . $user->getId(), 0755, true);
        }
        move_uploaded_file($upload_sldfile->getPathname(), $sld_path . "/sld/" . $user->getId() . "/" . $upload_sldfile->getClientOriginalName());
        $select_sldfile = $user->getId() . "/" . $upload_sldfile->getClientOriginalName();
      }
      $useruploadshapefile->setSldfileName($select_sldfile);
      $useruploadshapefile->setLabelField($select_labelfile);
      $useruploadshapefile->setTipField($select_tipfield);
      $em->persist($useruploadshapefile);
      $em->flush();
      return new Response(\json_encode(array('success' => true, 'message' => 'SLD file successfully uploaded!', 'data' => array('shapefile' => array('id' => $useruploadshapefile->getId(), 'shapefilename' => $useruploadshapefile->getShapefileName(), 'updated_at' => $useruploadshapefile->getUpdatedAt()), 'shapefile_topojson_url' => $this->generateUrl('default_shapefile_topojson'), 'shapefile_delete_url' => $this->generateUrl("default_shapefile_delete")))));
    }

    $conn = $this->get('database_connection');
    $shpDbname = $conn->getDatabase();
    $shpTablename = "useruploadshapefile_geoms_" . $useruploadshapefile->getId();

    $sql = "SELECT column_name FROM information_schema.columns WHERE table_name='" . $shpTablename . "'";
    $stmt = $conn->fetchAll($sql);

    $rowCount = count($stmt);
    $column_name_array = array();
    for ($i = 0; $i < $rowCount; $i++) {
      if ($stmt[$i]['column_name'] === 'the_geom' || $stmt[$i]['column_name'] === 'geom' || $stmt[$i]['column_name'] === 'the_geom4326') {
        unset($stmt[$i]);
      }
      else {
        array_push($column_name_array, $stmt[$i]['column_name']);
      }
      //   return new Response(\json_encode(array('success' => false, 'data' => 'label Field:' . strtolower($data['boundary_name_field2']) . ' not exist')));
    };








    if ($useruploadshapefile) {
      return array('success' => true, 'id' => $useruploadshapefile->getId(),'selected_tip_field' => $useruploadshapefile->getTipField(), 'selected_label_field' => $useruploadshapefile->getLabelField(), 'label_fields' => $column_name_array, 'selected_sldfile' => $useruploadshapefile->getSldfileName(), 'shapefilename' => $useruploadshapefile->getShapefileName(), 'sld_files' => $sld_files);
    }
    else {
      return array('success' => false, 'shapefilename' => 'F');
    }
  }

  /**
   * Welcome controller.
   *
   * @Route("/shapefile_topojson" , name="default_shapefile_topojson")
   * @Method({"GET"})
   */
  public function shapefile_topojsonAction() {
    $request = $this->getRequest();
    $id = $request->get('id');
    $user = $this->getUser();
    $shapefiles_path = $this->get('kernel')->getRootDir() . '/../Data';

    if (!$user) {
      return new Response(\json_encode(array('success' => false, 'type' => '', 'data' => 'Only logged in user can show map with topojson file data')));
    }
    if (intval($id) === -1) {
      $conn = $this->get('database_connection');
      $tsql = "select a.id as ogc_fid,a.id as ogc_id, a.name as keyname , a.geom_type , a.radius , a.buffer ,st_asgeojson(b.the_geom) as feature from userdrawgeometries a, userdrawgeometries_geom b where a.user_id=" . $user->getId() . " and a.id=b.userdrawgeometries_id";
      $stmt = $conn->fetchAll($tsql);
      return new Response(\json_encode(array('success' => true, 'filename' => 'draw', 'type' => 'geojson', 'data' => $stmt)));
    }
    $em = $this->getDoctrine()->getManager();
    $useruploadshapefile = $em->getRepository('Map2uCoreBundle:UserUploadShapefile')->findOneBy(array('id' => $id));
    if ($useruploadshapefile !== null) {
      $topojsonfile = $shapefiles_path . '/shapefiles/' . $this->getUser()->getId() . '/' . $useruploadshapefile->getTopojsonfileName();
      if (file_exists($topojsonfile) === true) {
        $json = null;
        if (trim($useruploadshapefile->getSldfilename()) !== '') {
          $json = $this->getSldContent($useruploadshapefile->getSldfilename());
        }
        $topojsonfile_data = file_get_contents($topojsonfile);
        return new Response(\json_encode(array('success' => true, 'filename' => $useruploadshapefile->getShapefileName(), 'sld' => $json, 'label_field' => $useruploadshapefile->getLabelField(), 'type' => 'topojson', 'data' => $topojsonfile_data)));
        //    return new Response(\json_encode(array('success' => true, 'type' => 'topojson', 'data' => $topojsonfile_data)));
      }
      else {
        return new Response(\json_encode(array('success' => false, 'type' => '', 'data' => 'Topojson ' . $topojsonfile . ' not exist!')));
      }
    }
    return new Response(\json_encode(array('success' => false, 'type' => '', 'data' => 'User Uploaded shape file not found!')));
  }

  /**
   * Welcome controller.
   *
   * @Route("/shapefile_delete" , name="default_shapefile_delete")
   * @Method({"GET"})
   */
  public function shapefile_deleteAction() {
    $request = $this->getRequest();
    $id = $request->get('id');
    $user = $this->getUser();
    $shapefiles_path = $this->get('kernel')->getRootDir() . '/../Data';
    if (!$user) {
      return new Response(\json_encode(array('success' => false, 'type' => '', 'message' => 'Only logged in user can show map with topojson file data')));
    }
    $em = $this->getDoctrine()->getManager();
    $useruploadshapefile = $em->getRepository('Map2uCoreBundle:UserUploadShapefile')->findOneBy(array('id' => $id, 'userId' => $user->getId()));
    if ($useruploadshapefile !== null) {
      $topojsonfile = $shapefiles_path . '/shapefiles/' . $this->getUser()->getId() . '/' . $useruploadshapefile->getTopojsonfileName();
      if (file_exists($topojsonfile) === true) {
        unlink($topojsonfile);
      }
      $shapefilename = $useruploadshapefile->getShapefileName();
      $em->remove($useruploadshapefile);
      $em->flush();
      $useruploadshapefile = $em->getRepository('Map2uCoreBundle:UserUploadShapefile')->findOneBy(array('userId' => $user->getId()));
      return new Response(\json_encode(array('success' => true, 'type' => '', 'action' => 'remove', 'filename' => $shapefilename)));
    }
    return new Response(\json_encode(array('success' => false, 'type' => '', 'action' => 'remove', 'message' => 'User Uploaded shape file not found!')));
  }

  /**
   * Welcome controller.
   *
   * @Route("/uploadshapefileform" , name="default_uploadshapefileform", options={"expose"=true})
   * @Method({"GET"})
   * @Template()
   */
  public function uploadshapefileformAction() {
    $request = $this->getRequest();
    $user = $this->getUser();
    if (!isset($user) || empty($user)) {
      return new Response(\json_encode(array('success' => false, 'type' => '', 'message' => 'Only logged in user can show map with topojson file data')));
    }
    return array();
  }

  /**
   * Welcome controller.
   *
   * @Route("/shapefilelistform" , name="default_shapefilelistform", options={"expose"=true})
   * @Method({"GET"})
   * @Template()
   */
  public function shapefilelistformAction() {

    $user = $this->getUser();
    if (!isset($user) || empty($user)) {
      return new Response(\json_encode(array('success' => false, 'type' => '', 'message' => 'Only logged in user can show shapefiles list')));
    }
    return array();
  }

  /* Params sld file name $string
   * return sld file content as json format
   *
   */

  private function getSldContent($sld_filename) {
    // sld path for sld file
    $sld_path = $this->get('kernel')->getRootDir() . '/../Data';;

    if (isset($sld_filename) && $sld_filename != '' && file_exists($sld_path . '/sld/' . $sld_filename)) {
      //    echo $layers[0]->getDefaultSldName();
      // read data from sld file
      $sldfile_content = file_get_contents($sld_path . '/sld/' . $sld_filename);

      // remove prefix ogc:
      $sldstring_temp = str_replace('ogc:', '', $sldfile_content);
      // remove prefix sld:
      $sldstring = str_replace('sld:', '', $sldstring_temp);
      $sldxml = simplexml_load_string($sldstring);
      $json = json_encode($sldxml);
      return $json;
    }
    return '{}';
  }

}
