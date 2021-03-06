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
 * <summary>This is extend of Map2u\DashboardBundle\Controller\DefaultController</summary>
 * <purpose>expose of routing of Map2u\DashboardBundle\Controller\DefaultController , add custom actions in this controller and override the old actions</purpose>
 */

namespace Application\Map2u\DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Map2u\DashboardBundle\Controller\DefaultController as BaseController;

/**
 * Map2u Dashboard Default controller.
 *
 * @Route("/dashboard")
 */
class DefaultController extends BaseController {
    
}
