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
 * <summary>This file is extend of Map2u\CoreBundle\Controller\HelpController</summary>
 * <purpose>expose of routing of Map2u\CoreBundle\Controller\HelpController , add custom actions in this controller and override the old actions</purpose>
 */

namespace Application\Map2u\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Map2u\CoreBundle\Entity\UploadfileLayer;
use Map2u\CoreBundle\Entity\UserUploadfile;
use Map2u\CoreBundle\Entity\UserUploadfileGeom;
use Map2u\CoreBundle\Controller\HelpController as BaseController;

/**
 * Help controller.
 *
 * @Route("/help")
 */
class HelpController extends BaseController {

    /**
     * show show help content page.
     *
     * @Route("/showcontent", name="help_showcontent", options={"expose"=true})
     * @Method("GET")
     */
    public function showcontentAction(Request $request) {
        $helpid = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $helpcontent = '';
        $helpfiletype = '';

        $help = $em->getRepository('YorkuJuturnaBundle:Help')->findOneBy(array('helptypeId' => $helpid,'active'=>true), array("updatedAt" => 'DESC'));
        if ($help === null) {
            
        } else {
            if ($help->getContent() !== null && trim($help->getContent()) !== '') {
                $helpcontent = $help->getContent();
            } else if ($help->getFileName() !== null && trim($help->getFileName()) !== '') {

                return $this->redirect($request->getBasePath().'/uploads/help/' . $help->getId() . "/" . $help->getFileName());
                //  $helpcontent = file_get_contents('./uploads/help/' . $help->getFileName());
                //   $helpfiletype = $help->getFileType();
            }
        }

        return new Response($helpcontent);
    }

}
