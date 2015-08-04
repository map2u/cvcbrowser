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
 * <summary>This is default controller with bundle YorkuJuturnaBundle</summary>
 * <purpose>default controller for about and help page display actions</purpose>
 */

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * JuturnBundle default controller.
 *
 * @Route("/juturnadefault")
 */
class DefaultController extends Controller {

    /**
     * dispaly default index page
     *
     * @Route("/", name="juturnadefault_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {

        $_locale = $request->attributes->get('_locale', $request->getLocale());
 

        return $this->render('YorkuJuturnaBundle:Default:index.html.twig', array('_locale' => $_locale));
    }

    /**
     * display about page
     *
     * @Route("/about", name="juturnadefault_about")
     * @Method("GET")
     * @Template()
     */
    public function aboutAction(Request $request) {

        $_locale = $request->attributes->get('_locale', $request->getLocale());


        return $this->render('YorkuJuturnaBundle:Default:about.html.twig', array('_locale' => $_locale));
    }

    /**
     * dispaly system admin help page
     *
     * @Route("/adminhelp", name="jdefault_adminhelp")
     * @Method("GET")
     * @Template()
     */
    public function adminhelpAction(Request $request) {
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        return $this->render('YorkuJuturnaBundle:Default:adminhelp.html.twig', array('_locale' => $_locale));
    }

    /**
     * dispaly how to use system help
     *
     * @Route("/systemhelp", name="jdefault_systemhelp")
     * @Method("GET")
     * @Template()
     */
    public function systemhelpAction(Request $request) {
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        return $this->render('YorkuJuturnaBundle:Default:systemhelp.html.twig', array('_locale' => $_locale));
    }

}
