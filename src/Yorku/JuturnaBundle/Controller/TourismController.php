<?php

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\DBAL\Types\Type;
use Yorku\JuturnaBundle\Entity\Users;

Type::overrideType('datetime', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('datetimetz', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('time', 'Doctrine\DBAL\Types\VarDateTimeType');

/**
 * Stations controller.
 *
 * @Route("/tourism")
 */
class TourismController extends Controller {

  /**
   * Lists all BenthicCollections entities.
   *
   * @Route("/", name="tourism_index")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = null; // $em->getRepository('YorkuJuturnaBundle:BenthicCollections')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Lists all BenthicCollections entities.
   *
   * @Route("/show", name="tourism_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction() {
    $em = $this->getDoctrine()->getManager();
    $request = $this->getRequest();
    $id = $request->get('id');
    $picture = $request->get('picture');
    $entities = null;
    if (isset($id) && !empty($id)) {
      $entities = $em->getRepository('YorkuJuturnaBundle:Tourism')->findOneById($id);
    }
    return array(
      'entities' => $entities,
    );
  }

  /**
   * Lists all BenthicCollections entities.
   *
   * @Route("/showpicture", name="tourism_showpicture")
   * @Method("GET")
   * @Template()
   */
  public function showpictureAction() {
    $em = $this->getDoctrine()->getManager();
    $request = $this->getRequest();
    $id = $request->get('id');
    $picture = $request->get('picture');
    $entities = null;
    if (isset($id) && !empty($id)) {
      $entities = $em->getRepository('YorkuJuturnaBundle:Tourism')->findOneById($id);
    }

    return array(
      'entities' => $entities,
      'picture' => $picture
    );
  }

}
