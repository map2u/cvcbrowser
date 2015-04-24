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
        $scaleText=array(10 => "1:500,000",11 => "1:250,000", 12 => "1:150,000", 13 => "1:70,000", 14 => "1:35,000", 15 => "1:15,000", 16 => "1:8,000", 17 => "1:4,000");
        $em = $this->getDoctrine()->getManager();
        $form1 = $this->get('form.factory')->create(new MapBookmarkFormType("Map2u\CoreBundle\Entity\MapBookmark"));
        $form2 = $this->get('form.factory')->create(new MapBookmarkFormType("Map2u\CoreBundle\Entity\MapBookmark"));
        $form3 = $this->get('form.factory')->create(new MapBookmarkFormType("Map2u\CoreBundle\Entity\MapBookmark"));
        if ($request->getMethod() === "POST") {
            $seq = $request->get('seq');

            if ($this->getUser()) {
                $bookmark = $em->getRepository('Map2uCoreBundle:MapBookmark')->findOneBy(array('userId' => $this->getUser()->getId(), 'seq' => $seq));
            } else {
                return new Response(\json_encode(array('success' => false, 'message' => 'Must be a logged in user!')));
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
            return new Response(\json_encode(array('success' => true, 'message' => 'Successfully saved!')));
        }
        $bookmarks = null;
        if ($this->getUser()) {
            $bookmarks = $em->getRepository('Map2uCoreBundle:MapBookmark')->findBy(array('userId' => $this->getUser()->getId()), array("seq" => 'ASC'));
        }
        return array("bookmarks" => $bookmarks, "form1" => $form1->createView(), "form2" => $form2->createView(), "form3" => $form3->createView());
    }

}
