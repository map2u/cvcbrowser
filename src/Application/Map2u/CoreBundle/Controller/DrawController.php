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
use Paradigma\Bundle\ImageBundle\Libs\ImageSize;
use Paradigma\Bundle\ImageBundle\Libs\ImageResizer;
use Yorku\JuturnaBundle\Entity\Story;
use Application\Map2u\CoreBundle\Entity\UserDrawGeometries;
use Map2u\CoreBundle\Controller\DrawController as BaseController;

/**
 * Welcome controller.
 *
 * @Route("/draw")
 */
class DrawController extends BaseController {

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/save", name="draw_save", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function saveAction() {

        $icon_path = $this->get('kernel')->getRootDir() . '/../web/images/markers';
        $user = $this->getUser();
        if (!isset($user) || empty($user)) {
            return new Response(\json_encode(array('success' => false, 'message' => 'You must log in to do this!')));
        }
        $request = $this->getRequest();
        $id = $request->get('id');
        $drawname = $request->get('name');
        $feature = $request->get('feature');
        $public = $request->get('public');
        $featurelayer_id = $request->get('featurelayer');

        if (gettype($feature) == 'string') {
            $feature = json_decode($feature);
        }
        $drawradius = $request->get('radius');
        $drawtype = $request->get('type');
        $drawbuffer = $request->get('buffer');
        $description = $request->get('description');
        $selected_marker = $request->get('select_marker');
        $upload_marker_icon = $request->files->get('upload_marker_icon');


        $update_geom = false;
//    var_dump($feature);
        $em = $this->getDoctrine()->getManager();
        if (!isset($id)) {
            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
        }
        if ((isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined'))) {
            $usergeometries = new UserDrawGeometries();
        } else {
            $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->find($id);

            $update_geom = true;
        }
        if ($usergeometries) {
            $usergeometries->setUserId($user->getId());
            $usergeometries->setUser($user);
            //    $usergeometries->setUserId(1);

            $featurelayer = $em->getRepository('Map2uCoreBundle:UserDrawLayer')->findOneBy(array("id" => $featurelayer_id));
            $usergeometries->setUserdrawlayer($featurelayer);
            
            $usergeometries->setName($drawname);
            if (isset($description)) {
                $usergeometries->setDescription($description);
            }
            if ($upload_marker_icon) {
                if (!file_exists($icon_path . "/" . $user->getId())) {
                    mkdir($icon_path . "/" . $user->getId(), 0755, true);
                }
                move_uploaded_file($upload_marker_icon->getPathname(), $icon_path . "/" . $user->getId() . "/" . $upload_marker_icon->getClientOriginalName());
                $selected_marker = $user->getId() . "/" . $upload_sldfile->getClientOriginalName();
                $usergeometries->setMarkerIcon($selected_marker);
            } else {
                if (isset($selected_marker)) {
                    $usergeometries->setMarkerIcon($selected_marker);
                }
            }

            $usergeometries->setGeomType($drawtype);
            $usergeometries->setRadius($drawradius);
            $usergeometries->setBuffer($drawbuffer);
            $em->persist($usergeometries);
            $em->flush();
            $usergeometries_id = $usergeometries->getId();

            $conn = $this->get('database_connection');
            $feature_geojson = $feature->geometry;
            if ($drawtype === 'circle' || $drawtype === 'marker') {
                $lng = $feature->geometry->coordinates[0];
                $lat = $feature->geometry->coordinates[1];
                if ($update_geom === true) {
                    $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('POINT($lng $lat)', 4326) where userdrawgeometries_id=$usergeometries_id";
                } else {

                    //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, st_geomfromgeojson('$feature_geojson'))";
                    $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, ST_GeomFromText('POINT($lng $lat)', 4326))";
                }
            }
            if ($drawtype === 'rectangle' || $drawtype === 'polygon') {
                $points = '';
                // var_dump(count($feature['geometry']['coordinates'][0]));

                foreach ($feature->geometry->coordinates[0] as $point) {

                    if ($points === '') {
                        $points = "$point[0]  $point[1]";
                    } else {
                        $points = $points . ",$point[0]  $point[1]";
                    }
                }
                if ($update_geom === true) {
                    $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('POLYGON(($points))', 4326) where userdrawgeometries_id=$usergeometries_id";
                } else {
                    //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, st_geomfromgeojson('$feature_geojson'))";
                    $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, ST_GeomFromText('POLYGON(($points))', 4326))";
                }
            }
            if ($drawtype === 'polyline') {
                $points = '';
                //    var_dump(count($feature['geometry']['coordinates']));
                //        var_dump($feature['geometry']['coordinates']);
                foreach ($feature->geometry->coordinates as $point) {

                    if ($points === '') {
                        $points = "$point[0]  $point[1]";
                    } else {
                        $points = $points . ",$point[0]  $point[1]";
                    }
                }
                if ($update_geom === true) {
                    $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('LINESTRING($points)', 4326) where userdrawgeometries_id=$usergeometries_id";
                } else {

                    //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, st_geomfromgeojson('$feature_geojson'))";
                    $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, ST_GeomFromText('LINESTRING($points)', 4326))";
                }
            }
            $stmt = $conn->query($sql);

            $this->moveuploadedImages($request, $em, $usergeometries);
            $this->moveuploadedVideo($request, $em, $usergeometries);
            $this->moveuploadedAudio($request, $em, $usergeometries);

            return new Response(\json_encode(array('success' => true, 'id' => $usergeometries_id)));
        } else {
            return new Response(\json_encode(array('success' => false, 'id' => $usergeometries_id, 'message' => 'User draw geometry id:' . $usergeometries_id . ' not found!')));
        }


        // st_geomfromgeojson (text)?

        return new Response(\json_encode(array('success' => false)));
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/createstory", name="draw_createstory", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function createstoryAction(Request $request) {

        if ($request->getMethod() == "POST") {
            try {
                $id = $request->get("id");
                $storyName = $request->get("name");
                $summary = $request->get("summary");
                $email = $request->get("email");
                $lat = $request->get("lat");
                $lng = $request->get("lng");
                $type = $request->get("type");
                $radius = $request->get("radius");
                $the_geom = $request->get("the_geom");

                $em = $this->getDoctrine()->getManager();

                $story = null;
                if (isset($id) && intval($id) > 0) {
                    $story = $em->getRepository("YorkuJuturnaBundle:Story")->find($id);
                }
                if ($story == null) {
                    $story = new Story();
                }
                $story->setStoryName($storyName);
                $story->setUser($this->getUser());
                $story->setSummary($summary);
                $story->setRadius($radius);
                $story->setType($type);
                $story->setEmail($email);
                $em->persist($story);
                $em->flush();
                $this->saveUploadedFiles($request, $story);
                $em->persist($story);
                $em->flush();

                $this->saveStoryGeom($story, $lat, $lng, $type, $the_geom);

                return new JsonResponse(array(
                    'success' => true,
                    'message' => "Save the story success!",
                    'id' => $story->getId()
                ));
            } catch (Exception $e) {
                return new JsonResponse(array(
                    'success' => true,
                    'message' => "Failed save the story, please try again!\n" . $e
                ));
            }
        }

        return array();
    }

    private function saveUploadedFiles($request, $story) {
        $imageFile = $request->files->get('image_files');

        $user = $this->getUser();
        $dir = './uploads/stories/' . $story->getId() . '/images';
        if (file_exists($dir) == false) {
            shell_exec("mkdir -p " . $dir);
        }
        $images_array = array();
        if ($imageFile != null) {
            if (is_array($imageFile)) {
                foreach ($imageFile as $file) {

                    if ($file != null) {
                        array_push($images_array, str_replace(" ", "_", $file->getClientOriginalName()));
                        $file->move($dir, str_replace(" ", "_", $file->getClientOriginalName()));
                        $resize = $this->get('image_resizer')->resize($dir . "/" . str_replace(" ", "_", $file->getClientOriginalName()), $dir . '/icon_' . str_replace(" ", "_", $file->getClientOriginalName()), new ImageSize(50, 40), ImageResizer::RESIZE_TYPE_CROP);
                        $resize = $this->get('image_resizer')->resize($dir . "/" . str_replace(" ", "_", $file->getClientOriginalName()), $dir . '/medium_' . str_replace(" ", "_", $file->getClientOriginalName()), new ImageSize(500, 400), ImageResizer::RESIZE_TYPE_AUTO);
                    }
                }
            } else {

                array_push($images_array, str_replace(" ", "_", $imageFile->getClientOriginalName()));
                $imageFile->move($dir, str_replace(" ", "_", $imageFile->getClientOriginalName()));
                $resize = $this->get('image_resizer')->resize($dir . "/" . str_replace(" ", "_", $imageFile->getClientOriginalName()), $dir . '/icon_' . str_replace(" ", "_", $imageFile->getClientOriginalName()), new ImageSize(50, 40), ImageResizer::RESIZE_TYPE_CROP);
                $resize = $this->get('image_resizer')->resize($dir . "/" . str_replace(" ", "_", $imageFile->getClientOriginalName()), $dir . '/medium_' . str_replace(" ", "_", $imageFile->getClientOriginalName()), new ImageSize(500, 400), ImageResizer::RESIZE_TYPE_AUTO);
            }
            $story->setImageFile(serialize($images_array));
        }
        $storyFile = $request->files->get('story_file');

        $dir = './uploads/stories/' . $story->getId() . '/pdf';
        if (file_exists($dir) == false) {
            shell_exec("mkdir -p " . $dir);
        }
        if ($storyFile != null) {
            $story->setStoryFileType($storyFile->getMimeType());
            $storyFile->move($dir, str_replace(" ", "_", $storyFile->getClientOriginalName()));
            $story->setStoryFile(str_replace(" ", "_", $storyFile->getClientOriginalName()));
        }
        return $story;
    }

    private function saveStoryGeom($story, $lat, $lng, $type, $the_geom) {
        $story_id = $story->getId();

        $conn = $this->get('database_connection');

        if ($the_geom == null) {
            return;
        }
        $feature = null;

        if (gettype($the_geom) == 'string') {

            $feature = json_decode(str_replace("'", '"', $the_geom));
        }

        if ($feature->geometry == null) {
            return;
        }


        //$feature_geojson = $the_geom->geometry;
        if ($type === 'circle' || $type === 'marker') {
            $lng = $feature->geometry->coordinates[0];
            $lat = $feature->geometry->coordinates[1];

            $sql = "UPDATE stories set the_geom = ST_GeomFromText('POINT($lng $lat)', 4326) where id=$story_id";
        }
        if ($type === 'rectangle' || $type === 'polygon') {
            $points = '';
            // var_dump(count($feature['geometry']['coordinates'][0]));

            foreach ($feature->geometry->coordinates[0] as $point) {

                if ($points === '') {
                    $points = "$point[0]  $point[1]";
                } else {
                    $points = $points . ",$point[0]  $point[1]";
                }
            }
            $sql = "UPDATE stories set the_geom = ST_GeomFromText('POLYGON(($points))', 4326) where id=$story_id";
        }
        if ($type === 'polyline') {
            $points = '';

            foreach ($feature->geometry->coordinates as $point) {

                if ($points === '') {
                    $points = "$point[0]  $point[1]";
                } else {
                    $points = $points . ",$point[0]  $point[1]";
                }
            }

            $sql = "UPDATE stories set the_geom = ST_GeomFromText('LINESTRING($points)', 4326) where id=$story_id";
        }
        $stmt = $conn->query($sql);
    }

}
