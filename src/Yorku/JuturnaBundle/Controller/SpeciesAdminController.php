<?php

namespace Yorku\JuturnaBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use  Symfony\Component\HttpFoundation\Request;

class SpeciesAdminController extends CRUDController {

  public function createAction(Request $request = NULL) {

    // the key used to lookup the template
    $templateKey = 'edit';

    if (false === $this->admin->isGranted('CREATE')) {
      throw new AccessDeniedException();
    }

    $object = $this->admin->getNewInstance();

    $this->admin->setSubject($object);

    /** @var $form \Symfony\Component\Form\Form */
    $form = $this->admin->getForm();
    $form->setData($object);

    if ($this->getRestMethod() == 'POST') {
      $form->bind($this->get('request'));

      $isFormValid = $form->isValid();

      // persist if the form was valid and if in preview mode the preview was approved
      if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {


        $images_file = $form['images_file']->getData();
        $videos_file = $form['videos_file']->getData();
        $audios_file = $form['audios_file']->getData();
        $bsuccess = true;
        $images_array = array();

        $dir = './uploads/images/species/';
        if (is_array($images_file)) {
          foreach ($images_file as $file) {

            if ($file != null) {
              array_push($images_array, $file->getClientOriginalName());
              $file->move($dir . 'pictures', $file->getClientOriginalName());
            }
          }
        }
        else {
          if ($images_file != null) {
            array_push($images_array, $images_file->getClientOriginalName());
            $images_file->move($dir . 'pictures', $images_file->getClientOriginalName());
          }
        }
        $object->setImages(json_encode($images_array));

        $this->admin->create($object);

        if ($this->isXmlHttpRequest()) {
          return $this->renderJson(array(
                'result' => 'ok',
                'objectId' => $this->admin->getNormalizedIdentifier($object)
          ));
        }

        $this->addFlash('sonata_flash_success', 'flash_create_success');
        // redirect to edit mode
        return $this->redirectTo($object);
      }

      // show an error message if the form failed validation
      if (!$isFormValid) {
        if (!$this->isXmlHttpRequest()) {
          $this->addFlash('sonata_flash_error', 'flash_create_error');
        }
      }
      elseif ($this->isPreviewRequested()) {
        // pick the preview template if the form was valid and preview was requested
        $templateKey = 'preview';
        $this->admin->getShow();
      }
    }

    $view = $form->createView();

    // set the theme for the current Admin Form
    $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

    return $this->render($this->admin->getTemplate($templateKey), array(
          'action' => 'create',
          'form' => $view,
          'object' => $object,
    ));
  }

  public function editAction($id = NULL,Request $request = NULL) {

    $templateKey = 'edit';

    

    $id = $this->get('request')->get($this->admin->getIdParameter());

    $object = $this->admin->getObject($id);

    if (!$object) {
      throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
    }

    if (false === $this->admin->isGranted('EDIT', $object)) {
      throw new AccessDeniedException();
    }

    $this->admin->setSubject($object);

    /** @var $form \Symfony\Component\Form\Form */
    $form = $this->admin->getForm();
    $form->setData($object);


    if ($this->getRestMethod() == 'POST') {
      
      $form->bind($this->get('request'));

      $isFormValid = $form->isValid();

      // persist if the form was valid and if in preview mode the preview was approved
      if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

        $images_file = $form['images_file']->getData();
        $videos_file = $form['videos_file']->getData();
        $audios_file = $form['audios_file']->getData();
        
        $bsuccess = true;
        
        $images_array = array();
        $videos_array = array();
        $audios_array = array();

        $dir = './uploads/images/species/';
        if (is_array($images_file)) {
          $this->addFlash('sonata_flash_success', 'test1');
          var_dump($images_file);
          
          foreach ($images_file as $file) {

            if ($file != null) {
              array_push($images_array, $file->getClientOriginalName());
              $file->move($dir . 'pictures', $file->getClientOriginalName());
            }
          }
        }
        else {
          
          $this->addFlash('sonata_flash_success', 'test2='.count($images_file));
          echo "test";
          if ($images_file != null) {
            array_push($images_array, $images_file->getClientOriginalName());
            $images_file->move($dir . 'pictures', $images_file->getClientOriginalName());
          }
        }

//        var_dump($images_array);
        if (is_array($videos_file)) {
          foreach ($videos_file as $file) {

            if ($file != null) {
              array_push($videos_array, $file->getClientOriginalName());
              $file->move($dir . 'pictures', $file->getClientOriginalName());
            }
          }
        }
        else {
          if ($videos_file != null) {
            array_push($videos_array, $videos_file->getClientOriginalName());
            $videos_file->move($dir . 'pictures', $videos_file->getClientOriginalName());
          }
        }
        if (is_array($audios_file)) {
          foreach ($audios_file as $file) {

            if ($file != null) {
              array_push($audios_array, $file->getClientOriginalName());
              $file->move($dir . 'pictures', $file->getClientOriginalName());
            }
          }
        }
        else {
          if ($audios_file != null) {
            array_push($audios_array, $audios_file->getClientOriginalName());
            $audios_file->move($dir . 'pictures', $audios_file->getClientOriginalName());
          }
        }

        $object->setImages(serialize($images_array));
        $object->setVideos(serialize($videos_array));
        $object->setAudios(serialize($audios_array));

//        var_dump(json_encode($images_array));

        $this->admin->update($object);


        if ($this->isXmlHttpRequest()) {
          return $this->renderJson(array(
                'result' => 'ok',
                'objectId' => $this->admin->getNormalizedIdentifier($object)
          ));
        }

        $this->addFlash('sonata_flash_success', 'flash_edit_success');

        // redirect to edit mode
        return $this->redirectTo($object);
      }

      // show an error message if the form failed validation
      if (!$isFormValid) {
        if (!$this->isXmlHttpRequest()) {
          $this->addFlash('sonata_flash_error', 'flash_edit_error');
        }
      }
      elseif ($this->isPreviewRequested()) {
        // enable the preview template if the form was valid and preview was requested
        $templateKey = 'preview';
        $this->admin->getShow();
      }
    }

    $view = $form->createView();

    // set the theme for the current Admin Form
    $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());
   // return $this->render($this->admin->getTemplate($templateKey), array(
    return $this->render("YorkuJuturnaBundle:Species:base_edit.html.twig", array(
          'action' => 'edit',
          'form' => $view,
          'object' => $object,
    ));






//        
//        $result = parent::editAction($id);
//
//        if ($this->get('request')->getMethod() == 'POST')
//        {
//            $flash = $this->get('session');//->getFlash('sonata_flash_success');
//
//            if (!empty($flash) && $flash == 'flash_create_success')
//            {
//                 $dir = './shapefiles';
//                 
    #$userManager = $this->container->get('fos_user.user_manager');
    #$user = $this->container->get('context.user');
    #$userManager = $session->get('username');
//                $user = $this->container->get('security.context')->getToken()->getUser()->getUsername();
//
//                $attachment = new Attachment();
//                $attachment->setPath('/tmp/image.jpg');
//                $attachment->setNotes('nothing interesting to say');
//                $attachment->getSystemUser($user);
//
//                $em = $this->getDoctrine()->getEntityManager();
    //               $em->persist($product);
    //        $em->flush();
//                
//            $dir = './shapefiles';
//
//            if ($form->isValid()) {
//
//                $data = $form->getData();
//
//
//                if ($data['proj_file'] != null)
//                    $data['proj_file']->move($dir, $data['proj_file']->getClientOriginalName());
//
//                $epsg = $this->checkEPSG(strval($data['epsg_number']), $dir . '/' . $data['proj_file']->getClientOriginalName());
//                if ($epsg['epsg'] === 0) {
//                    return array('errors' => $epsg['errors'], 'form' => $form->createView());
//                }
//                // if pass the epsg number check, then save uploaded shape file to folder web/shapefiles
//                $data['shape_file']->move($dir, $data['shape_file']->getClientOriginalName());
//                $data['index_file']->move($dir, $data['index_file']->getClientOriginalName());
//                $data['dbf_file']->move($dir, $data['dbf_file']->getClientOriginalName());
//
//                $output = shell_exec('ogr2ogr2 -overwrite -f "PostgreSQL" PG:"host=127.0.0.1 user=jzhao dbname=juturna3_0 password=jzhao" -nlt GEOMETRY -a_srs EPSG:' . $epsg['epsg'] . ' -lco GEOMETRY_NAME=geom -nln geomupload_temp ' . $dir . '/' . $data['shape_file']->getClientOriginalName());
//
//                $watershed_column_return = $this->isColumnExist($conn, 'geomupload_temp', $data['watershed_fieldname']);
//                if ($watershed_column_return !== false) {
//                    array_push($errors, $watershed_column_return);
//                }
//                $subwatershed_column_return = $this->isColumnExist($conn, 'geomupload_temp', $data['subwatershed_fieldname']);
//                if ($subwatershed_column_return !== false) {
//                    array_push($errors, $subwatershed_column_return);
//                }
//                /*                $sql="SELECT column_name FROM information_schema.columns WHERE table_name='geomupload_temp' and column_name='".$data['watershed_fieldname']."'";
//                  $stmt = $conn->fetchAll($sql);
//                  $rowCount = count($stmt);
//                  if($rowCount==0)
//                  {
//                  array_push($errors,"Sorry,the watershed field name:".$data['watershed_fieldname']." is not found in shape file!");
//                  }
//                  $sql="SELECT column_name FROM information_schema.columns WHERE table_name='geomupload_temp' and column_name='".$data['subwatershed_fieldname']."'";
//                  $stmt = $conn->fetchAll($sql);
//                  $rowCount = count($stmt);
//                  if($rowCount==0)
//                  {
//                  array_push($errors,"Sorry,the subwatershed field name:".$data['subwatershed_fieldname']." is not found in shape file!");
//                  }
//                 * 
//                 */
//                if (count($errors) > 0) {
//                    return array("errors" => $errors, 'form' => $form->createView());
//                }
//
//
//                $conn = $this->get('database_connection');
//                if ($this->getUser()) {
//                    
//                } else {
//                    $this->get('session')->getFlashBag()->add(
//                            'notice', 'Your changes were saved!'
//                    );
//                }
//                //               $options = array('noparts' => false);
////         echo 
//                //              $filename = $dir . "/" . $data['shape_file']->getClientOriginalName();
//                // check if there are any duplicate watershed name already exist in watewrsheds tables;
//                $sql = "select id , watershed_name from watersheds where watershed_name in (select " . $data['watershed_fieldname'] . " from geomupload_temp)";
//
//
//// start watershed polygon process
//                //               $overlap_results = $conn->fetchAll($sql);
//                //               $overlap_size = sizeof($overlap_results);
//                // empty the temp table;
//                $sql = "delete from temp_polygon ";
//                $stmt = $conn->query($sql);
//                // create watershed union polygon and insert into temp table
//                $sql = "insert into temp_polygon (watershed_name,the_geom)  select " . $data['watershed_fieldname'] . ",st_union(geom) as the_geom from  geomupload_temp group by " . $data['watershed_fieldname'];
//                $stmt = $conn->query($sql);
//
//                if ($data['overwrite'] === true) {
//                    // insert into temp_polygon (watershed_name,the_geom)  select  name,st_union(geom) as the_geom from  geomupload_temp group by name;
//                    $sql = "update watersheds set the_geom=temp_polygon.the_geom,updated_at=now() from temp_polygon  where watersheds.watershed_name=temp_polygon.watershed_name";
//                    $stmt = $conn->query($sql);
//                }
//                // delete those polygons from temp_polygon not insert into watersheds table
//                //               $sql = "delete from geomupload_temp where " . $data['watershed_fieldname'] . " in ( select watershed_name from  watersheds )";
//                $sql = "delete from temp_polygon where watershed_name in ( select watershed_name from  watersheds )";
//                $stmt = $conn->query($sql);
//
//                // insert shape file polygon into watershed table without duplicate watershed name
//                $sql = "insert into watersheds (user_id,watershed_letter_id,watershed_name,the_geom,created_at,updated_at)  select " . $this->getUser()->getId() . ", upper(substring(watershed_name,0,3)),watershed_name,the_geom,now(),now() from  temp_polygon ";
//                $stmt = $conn->query($sql);
//
//// end watershed polygon process 
////            
//// start subwatershed polygon process
//                $sql = "delete from temp_polygon ";
//                $stmt = $conn->query($sql);
//// create subwatershed union polygon and insert into temp table
//                $sql = "insert into temp_polygon (watershed_name,subwatershed_name,the_geom)  select " . $data['watershed_fieldname'] . " as watershed_name, " . $data['subwatershed_fieldname'] . " as subwatershed_name,st_union(geom) as the_geom from  geomupload_temp group by " . $data['watershed_fieldname'] . "," . $data['subwatershed_fieldname'];
//// insert into temp_polygon (watershed_name,the_geom)  select  name,st_union(geom) as the_geom from  geomupload_temp group by name;
//                $stmt = $conn->query($sql);
//
//                if ($data['overwrite'] === true) {
//// empty the temp table;
//                    $sql = "update subwatersheds set the_geom=a.the_geom,updated_at=now() from temp_polygon a,watersheds b where subwatersheds.subwatershed_name=a.subwatershed_name and subwatersheds.watershed_id=b.id and a.watershed_name=b.watershed_name";
//                    $stmt = $conn->query($sql);
//                }
//
//// delete those polygons not insert into watersheds table
//                $sql = "delete from temp_polygon where (watershed_name,subwatershed_name) in ( select watersheds.watershed_name, subwatersheds.subwatershed_name from  watersheds,subwatersheds where subwatersheds.watershed_id=watersheds.id)";
//                $stmt = $conn->query($sql);
//
//                $sql = "insert into subwatersheds (user_id,watershed_id,subwatershed_name,the_geom,created_at,updated_at)  select " . $this->getUser()->getId() . ",a.id,b.subwatershed_name,b.the_geom,now(),now() from  temp_polygon b, watersheds a where a.watershed_name=b.watershed_name";
//                $stmt = $conn->query($sql);
//
//
//// end subwatershed polygon process      
//            }
//        }
//        $formView = $form->createView();
//        return array("form" => $formView);
//                
//                
//                
//                
//            }
//        }
//
//        return $result;
  }

}
