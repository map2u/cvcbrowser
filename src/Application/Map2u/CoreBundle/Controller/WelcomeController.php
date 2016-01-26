<?php

namespace Application\Map2u\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Map2u\CoreBundle\Controller\WelcomeController as BaseController;

/**
 * Welcome controller.
 *
 * @Route("/welcome")
 */
class WelcomeController extends BaseController {

    /**
     * show welcome page.
     *
     * @Route("/", name="welcome_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {

        $locale = $request->attributes->get('_locale', $request->getLocale());
        $em = $this->getDoctrine()->getManager();
        if ($this->getUser()) {
            $bookmarks = $em->getRepository('Map2uCoreBundle:MapBookmark')->findBy(array('userId' => $this->getUser()->getId()), array("name" => 'ASC'));
        } else {
            $bookmarks = null;
        }
//    $systemparams = $em->getRepository('YorkuJuturnaBundle:Systemparams')->findAll();
//
        return $this->render('Map2uCoreBundle:Welcome:index.html.twig', array('_locale' => $locale, 'bookmarks' => $bookmarks));
    }

    public function headerAction() {

        //  $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        //   $logos = $em->getRepository('YorkuJuturnaBundle:Logo')->findBy(array('enabled' => true), array("showSeq" => 'ASC'));
        //   $systemparams = $em->getRepository('YorkuJuturnaBundle:Systemparams')->findAll();
        $locale = $request->attributes->get('_locale', $request->getLocale());

        //   if ($systemparams) {
        //     $systemparam = $systemparams[0];
        //   }
        //   else {
        //     $systemparam = null;
        //   }
        $localeMenuImg = $request->get('locale_menu_img');
//    $twig = $this->container->get("twig");
//    $twig->addGlobal("logos", $logos);

        return $this->render('Map2uCoreBundle:Welcome:header.html.twig', array('locale_menu_img' => $localeMenuImg, '_locale' => $locale));
    }

    public function headerLogosAction() {

        //   $em = $this->getDoctrine()->getManager();
//    $logos = $em->getRepository('YorkuJuturnaBundle:Logo')->findBy(array('enabled' => true), array("showSeq" => 'ASC'));
//    $systemparams = $em->getRepository('YorkuJuturnaBundle:Systemparams')->findAll();
//
//    if ($systemparams) {
//      $systemparam = $systemparams[0];
//    }
//    else {
//      $systemparam = null;
//    }
//
//    $twig = $this->container->get("twig");
//    $twig->addGlobal("logos", $logos);

        return $this->render('Map2uCoreBundle:Welcome:header_logos.html.twig');
    }

    public function loginformjsAction() {
        return $this->render('Map2uCoreBundle:Welcome:loginformjs.html.twig');
    }

    public function footerAction() {
        return $this->render('Map2uCoreBundle:Welcome:footer.html.twig');
    }

}
