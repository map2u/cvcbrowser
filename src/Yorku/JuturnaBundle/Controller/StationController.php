<?php

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yorku\JuturnaBundle\Entity\Station;
use Yorku\JuturnaBundle\Form\StationType;
use Doctrine\DBAL\Types\Type;

Type::overrideType('datetime', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('datetimetz', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('time', 'Doctrine\DBAL\Types\VarDateTimeType');

/**
 * Station controller.
 *
 * @Route("/station")
 */
class StationController extends CRUDController {
  
   public function indexAction(){
     return array();
   }
   public function homepageAction() {
        $em = $this->getDoctrine()->getManager();
        $stations=$em->getRepository("YorkuJuturnaBundle:Station")->findAll();
 
     return $this->render("YorkuJuturnaBundle:Station:homepage.html.twig",array("stations"=>$stations));
   }
   
}
