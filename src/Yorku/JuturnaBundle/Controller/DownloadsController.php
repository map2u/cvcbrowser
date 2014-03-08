<?php

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Downloads controller.
 *
 * @Route("/downloads")
 */
class DownloadsController extends Controller
{
       /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/station", name="downloads_station")
     * @Method("GET")
     * @Template()
     */
    public function stationAction() {
        return array();
    }
}
