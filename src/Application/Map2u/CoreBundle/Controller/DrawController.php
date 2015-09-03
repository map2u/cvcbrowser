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
use Map2u\CoreBundle\Controller\DrawController as BaseController;
use Gaufrette\Exception;
use Application\Sonata\UserBundle\Entity\User;

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
    public function saveAction(Request $request) {

        $icon_path = $this->get('kernel')->getRootDir() . '/../web/images/markers';
        $user = $this->getUser();
        if (!isset($user) || empty($user)) {
            return new Response(\json_encode(array('success' => false, 'message' => 'You must log in to do this!')));
        }
        $req_params = $this->getSaveActionReq($request);

        if (gettype($req_params['feature']) == 'string') {
            $req_params['feature'] = json_decode($req_params['feature']);
        }


        $update_geom = false;

        $em = $this->getDoctrine()->getManager();

        if (!isset($req_params['id'])) {
            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
        }

        if ((isset($req_params['id']) && ( $req_params['id'] === 0 || $req_params['id'] === '0' || $req_params['id'] === 'undefined'))) {
            $usergeometries = new UserDrawGeometries();
        } else {
            $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->find($req_params['id']);

            $update_geom = true;
        }
        if ($usergeometries) {

            $this->setSaveActionUserGeometry($usergeometries, $em, $user, $req_params, $icon_path);

            $usergeometries_id = $usergeometries->getId();
            $this->saveActionGeometriesSave($usergeometries_id, $req_params, $update_geom);

            $this->moveuploadedImages($request, $em, $usergeometries);
            $this->moveuploadedVideo($request, $em, $usergeometries);
            $this->moveuploadedAudio($request, $em, $usergeometries);

            return new Response(\json_encode(array('success' => true, 'id' => $usergeometries_id)));
        } else {
            return new Response(\json_encode(array('success' => false, 'id' => $usergeometries_id, 'message' => 'User draw geometry id:' . $usergeometries_id . ' not found!')));
        }


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

        $dir = './uploads/stories/' . $story->getId() . '/images';
        if (file_exists($dir) == false) {
            shell_exec("mkdir -p " . $dir);
        }


        $images_array = $this->resizeUploadedImageFiles($imageFile, $dir);

        $story->setImageFile(serialize($images_array));

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

    private function resizeUploadedImageFiles($imageFile, $dir) {
        $images_array = array();
        if ($imageFile === null) {
            return $images_array;
        }
        if (is_array($imageFile)) {
            foreach ($imageFile as $file) {

                if ($file !== null) {
                    array_push($images_array, str_replace(" ", "_", $file->getClientOriginalName()));
                    $file->move($dir, str_replace(" ", "_", $file->getClientOriginalName()));
                    $this->get('image_resizer')->resize($dir . "/" . str_replace(" ", "_", $file->getClientOriginalName()), $dir . '/icon_' . str_replace(" ", "_", $file->getClientOriginalName()), new ImageSize(50, 40), ImageResizer::RESIZE_TYPE_CROP);
                    $this->get('image_resizer')->resize($dir . "/" . str_replace(" ", "_", $file->getClientOriginalName()), $dir . '/medium_' . str_replace(" ", "_", $file->getClientOriginalName()), new ImageSize(500, 400), ImageResizer::RESIZE_TYPE_AUTO);
                }
            }
        } else {

            array_push($images_array, str_replace(" ", "_", $imageFile->getClientOriginalName()));
            $imageFile->move($dir, str_replace(" ", "_", $imageFile->getClientOriginalName()));
            $this->get('image_resizer')->resize($dir . "/" . str_replace(" ", "_", $imageFile->getClientOriginalName()), $dir . '/icon_' . str_replace(" ", "_", $imageFile->getClientOriginalName()), new ImageSize(50, 40), ImageResizer::RESIZE_TYPE_CROP);
            $this->get('image_resizer')->resize($dir . "/" . str_replace(" ", "_", $imageFile->getClientOriginalName()), $dir . '/medium_' . str_replace(" ", "_", $imageFile->getClientOriginalName()), new ImageSize(500, 400), ImageResizer::RESIZE_TYPE_AUTO);
        }

        return $images_array;
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

    /**
     * 
     * @param type $request
     * @return array
     */
    private function getSaveActionReq($request) {
        $result = array();
        $result['id'] = $request->get('id');
        $result['drawname'] = $request->get('name');
        $result['feature'] = $request->get('feature');
        $result['public'] = $request->get('public');
        $result['featurelayer_id'] = $request->get('featurelayer');
        $result['drawradius'] = $request->get('radius');
        $result['drawtype'] = $request->get('type');
        $result['drawbuffer'] = $request->get('buffer');
        $result['description'] = $request->get('description');
        $result['selected_marker'] = $request->get('select_marker');
        if ($request->files) {
            $result['upload_marker_icon'] = $request->files->get('upload_marker_icon');
        } else {
            $result['upload_marker_icon'] = null;
        }

        return $result;
    }

    /**
     * 
     * @param UserDrawGeometries $usergeometries
     * @param \Doctrine\ORM\EntityManager $em
     * @param User $user
     * @param array $req_params
     * @param string $icon_path
     * @return UserDrawGeometries
     */
    //private function setSaveActionUserGeometry(Application\Map2u\CoreBundle\Entity\UserDrawGeometries $usergeometries, \Doctrine\ORM\EntityManager $em, Application\Sonata\UserBundle\Entity\User $user, array $req_params, string $icon_path) {
    private function setSaveActionUserGeometry($usergeometries, $em, $user, $req_params, $icon_path) {
        $usergeometries->setUserId($user->getId());
        $usergeometries->setUser($user);
        $featurelayer = $em->getRepository('Map2uCoreBundle:UserDrawLayer')->findOneBy(array("id" => $req_params['featurelayer_id']));
        $usergeometries->setUserdrawlayer($featurelayer);

        $usergeometries->setName($req_params['drawname']);
        if (isset($req_params['description'])) {
            $usergeometries->setDescription($req_params['description']);
        }

        $this->moveuploadedMarkerIcon($usergeometries, $req_params, $user, $icon_path);


        $usergeometries->setGeomType($req_params['drawtype']);
        $usergeometries->setRadius($req_params['drawradius']);
        $usergeometries->setBuffer($req_params['drawbuffer']);
        $em->persist($usergeometries);
        $em->flush();

        return $usergeometries;
    }

    /**
     * 
     * @param UserDrawGeometries $usergeometries
     * @param array $req_params
     * @param User $user
     * @param string $icon_path
     * @return UserDrawGeometries
     */
    private function moveuploadedMarkerIcon(UserDrawGeometries $usergeometries, array $req_params, User $user, $icon_path) {
        if ($req_params['upload_marker_icon']) {
            if (!file_exists($icon_path . "/" . $user->getId())) {
                mkdir($icon_path . "/" . $user->getId(), 0755, true);
            }
            move_uploaded_file($req_params['upload_marker_icon']->getPathname(), $icon_path . "/" . $user->getId() . "/" . $req_params['upload_marker_icon']->getClientOriginalName());
            $selected_marker = $user->getId() . "/" . $req_params['upload_sldfile']->getClientOriginalName();
            $usergeometries->setMarkerIcon($selected_marker);
        } else {
            if (isset($req_params['selected_marker'])) {
                $usergeometries->setMarkerIcon($req_params['selected_marker']);
            }
        }
        return $usergeometries;
    }

    private function saveActionGeometriesSave($usergeometries_id, array $req_params, $update_geom) {

        $conn = $this->get('database_connection');

        if ($req_params['drawtype'] === 'circle' || $req_params['drawtype'] === 'marker') {
            $lng = $req_params['feature']->geometry->coordinates[0];
            $lat = $req_params['feature']->geometry->coordinates[1];
            if ($update_geom === true) {
                $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('POINT($lng $lat)', 4326) where userdrawgeometries_id=$usergeometries_id";
            } else {

                //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, st_geomfromgeojson('$feature_geojson'))";
                $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometries_id, ST_GeomFromText('POINT($lng $lat)', 4326))";
            }
        }
        if ($req_params['drawtype'] === 'rectangle' || $req_params['drawtype'] === 'polygon') {
            $points = '';
            // var_dump(count($feature['geometry']['coordinates'][0]));

            foreach ($req_params['feature']->geometry->coordinates[0] as $point) {

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
        if ($req_params['drawtype'] === 'polyline') {
            $points = '';
            //    var_dump(count($feature['geometry']['coordinates']));
            //        var_dump($feature['geometry']['coordinates']);
            foreach ($req_params['feature']->geometry->coordinates as $point) {

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
    }

}
