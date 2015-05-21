<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yorku\JuturnaBundle\Entity\Leadername;
use Yorku\JuturnaBundle\Form\LeadernameType;

/**
 * Health Connectivity controller.
 *
 * @Route("/healthConnect")
 */
class HealthConnectivityController extends Controller
{

    /**
     * Lists all Leadername entities.
     *
     * @Route("/", name="healthConnect_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('YorkuJuturnaBundle:HealthConnectivity')->findAll();

        return array(
            'entities' => $entities,
        );
    }
}