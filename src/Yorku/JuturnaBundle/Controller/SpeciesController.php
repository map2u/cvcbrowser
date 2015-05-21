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
 * Species controller.
 *
 * @Route("/species")
 */
class SpeciesController extends Controller {
//class SpeciesController extends CRUDController {

   /**
     * species all species entities.
     *
     * @Route("/", name="species_index")
     * @Method("GET")
     * @Template()
   */ 
  
   public function indexAction(){
     return array();
   }

/**
     * species introduce.
     *
     * @Route("/introduce", name="species_introduce")
     * @Method("GET")
     * @Template()
   */    
   public function introduceAction() {
        $em = $this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $id=$request->get('id');
    //    var_dump($id);
        
        $species=$em->getRepository("YorkuJuturnaBundle:Species")->findBy(array('id'=>$id));
//        $species=$em->getRepository("YorkuJuturnaBundle:Species")
//            ->createQueryBuilder('p')
//            ->leftJoin('p.station','c')
//            ->where('p.id ='.$id)
//            ->orderBy('c.stationName', 'asc')
//            ->getQuery() 
//            ->getResult();
//        
//        var_dump($species);
     //   $stations=$em->getRepository("YorkuJuturnaBundle:Station")->findAll();
 
     return $this->render("YorkuJuturnaBundle:Species:introduce.html.twig",array("species"=>$species));
   }
  /**
     * species all species entities.
     *
     * @Route("/observation", name="species_observation")
     * @Method("GET")
     * @Template()
   */    
   public function observationAction() {
        $em = $this->getDoctrine()->getManager();
        
        $id=$this->getRequest()->get('id');
        $species=$em->getRepository("YorkuJuturnaBundle:Species")->findOneBy(array('id'=>$id));

        $observations=$em->getRepository("YorkuJuturnaBundle:BirdObservation")
            ->createQueryBuilder('p')
            ->leftJoin('p.station','c')
            ->where('p.species ='.$species->getID())
            ->orderBy('c.stationName', 'asc')
            ->getQuery() 
            ->getResult();
 
     return $this->render("YorkuJuturnaBundle:Species:observation.html.twig",array("observations"=>$observations));
   }
  /**
     * species all species entities.
     *
     * @Route("/show", name="species_show")
     * @Method("GET")
     * @Template()
   */    
   public function showAction() {
        $em = $this->getDoctrine()->getManager();
        
        $id=$this->getRequest()->get('id');
    //    $species=$em->getRepository("YorkuJuturnaBundle:Species")->findBy(array('code'=>$code));
        
     //   $stations=$em->getRepository("YorkuJuturnaBundle:Station")->findAll();
 
     return $this->render("YorkuJuturnaBundle:Species:show.html.twig",array("id"=>$id));
   }
   
}
