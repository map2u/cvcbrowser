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
 * <summary>This file is extend of Map2u\CoreBundle\Controller\UserAccountController</summary>
 * <purpose>expose of routing of Map2u\CoreBundle\Controller\UserAccountController , add custom actions in this controller and override the old actions</purpose>
 */

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
use Map2u\CoreBundle\Controller\UserAccountController as BaseController;
use Application\Map2u\CoreBundle\Form\Type\MapBookmarkFormType;

/**
 * Map2u Core Default controller.
 *
 * @Route("/account")
 */
class UserAccountController extends BaseController {

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/profile", name="useraccount_profile", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function profileAction(Request $request) {
        return $this->redirect($this->generateUrl('useraccount_profileedit', array('success' => false)));
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/profileedit", name="useraccount_profileedit", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function profileeditAction(Request $request) {
        return array();
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/mapbookmark", name="useraccount_mapbookmark", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function mapbookmarkAction(Request $request) {
        $scaleText = array(10 => "1:500,000", 11 => "1:250,000", 12 => "1:150,000", 13 => "1:70,000", 14 => "1:35,000", 15 => "1:15,000", 16 => "1:8,000", 17 => "1:4,000");
        $em = $this->getDoctrine()->getManager();
        $form1 = $this->get('form.factory')->create(new MapBookmarkFormType("Map2u\CoreBundle\Entity\MapBookmark"));
        $form2 = $this->get('form.factory')->create(new MapBookmarkFormType("Map2u\CoreBundle\Entity\MapBookmark"));
        $form3 = $this->get('form.factory')->create(new MapBookmarkFormType("Map2u\CoreBundle\Entity\MapBookmark"));
        $seq = $request->get('seq');
        if ($request->getMethod() === "POST"&&isset($seq)&&$seq!==null) {
            

            if ($this->getUser()) {
                $bookmark = $em->getRepository('Map2uCoreBundle:MapBookmark')->findOneBy(array('userId' => $this->getUser()->getId(), 'seq' => $seq));
            } else {
                return new Response(\json_encode(array('success' => false, 'message' => 'You must log in to do this!')));
            }
            if (!isset($bookmark) || $bookmark == null) {
                $bookmark = new \Map2u\CoreBundle\Entity\MapBookmark();
            }

            $data = $request->get("map2u_mapbookmark");
            $bookmark->setSeq($seq);
            $bookmark->setName($data['name']);
            $bookmark->setScaleText($scaleText[intval($data['zoomLevel'])]);
            $bookmark->setZoomLevel(intval($data['zoomLevel']));
            $bookmark->setAddress($data['address']);
            $bookmark->setLat(floatval($request->get('lat')));
            $bookmark->setLng(floatval($request->get('lng')));
            $bookmark->setUser($this->getUser());
            $em->persist($bookmark);
            $em->flush();
            return new Response(\json_encode(array('success' => true, "seq" => $seq, "zoom" => $data['zoomLevel'], "lat" => $request->get('lat'), "lng" => $request->get('lng'), 'address' => $data['address'], 'title' => $data['name'] . " " . $scaleText[intval($data['zoomLevel'])], 'message' => 'Successfully saved!')));
        }
        $bookmarks = null;
        if ($this->getUser()) {
            $bookmarks = $em->getRepository('Map2uCoreBundle:MapBookmark')->findBy(array('userId' => $this->getUser()->getId()), array("seq" => 'ASC'));
        }
        return array("form1"=>$form1->createView(),"form2"=>$form2->createView(),"form3"=>$form3->createView(),'bookmarks'=>$bookmarks,"scaleText"=>$scaleText);//$this->redirect($this->generateUrl('useraccount_mapbookmarkedit'));
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/mapbookmarkedit", name="useraccount_mapbookmarkedit", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function mapbookmarkeditAction(Request $request) {
        return array();
    }

}
