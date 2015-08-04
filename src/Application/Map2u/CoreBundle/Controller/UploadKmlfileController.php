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
 * <summary>This file is extend of Map2u\CoreBundle\Controller\UploadKmlfileController</summary>
 * <purpose>expose of routing of Map2u\CoreBundle\Controller\UploadKmlfileController , add custom actions in this controller and override the old actions</purpose>
 */

namespace Map2u\CoreBundle\Controller;

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
use Map2u\CoreBundle\Controller\UploadKmlfileController as BaseController;

/**
 * Map2u Core UploadKmlfile controller.
 *
 * @Route("/")
 */
class UploadKmlfileController extends BaseController {
    
}
