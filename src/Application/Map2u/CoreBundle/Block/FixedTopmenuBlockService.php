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
 * <summary>This file is extend of Map2u\CoreBundle\Block\FixedTopmenuBlockService</summary>
 * <purpose>based on Map2u\CoreBundle\Block\FixedTopmenuBlockService to override some actions and display contents</purpose>
 */

namespace Application\Map2u\CoreBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\CoreBundle\Model\ManagerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Map2u\CoreBundle\Block\FixedTopmenuBlockService as baseFixedTopmenuBlockService;
use Doctrine\ORM\EntityManager;

/**
 *
 * @author     Joseph Zhao jzhao@map2u.com
 */
class FixedTopmenuBlockService extends baseFixedTopmenuBlockService {

    private $container;

    /**
     * @param string          $name
     * @param EngineInterface $templating
     */
    public function __construct($name, $templating, EntityManager $entityManager, ContainerInterface $container) {
        $this->container = $container;
        parent::__construct($name, $templating, $entityManager);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {
        $criteria = array(
            'mode' => $blockContext->getSetting('mode')
        );
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($this->container->get('security.context')
                        ->getToken()->getUser());
        $mapbookmarks = null;


        $ecosystems = $this->em->getRepository('YorkuJuturnaBundle:EcoSystemService')->findBy(array(), array("id" => "ASC"));
        if ($user && $user != 'anon.') {
            $mapbookmarks = $this->em->getRepository('Map2uCoreBundle:MapBookmark')->findBy(array("userId" => $user->getId()), array("seq" => "ASC"));
        }
        $wellbeingdomains = $this->em->getRepository('YorkuJuturnaBundle:HumanWellBeingDomain')->findBy(array(), array("id" => "ASC"));

        $parameters = array(
            'context' => $blockContext,
            'settings' => $blockContext->getSettings(),
            'ecosystems' => $ecosystems,
            'wellbeingdomains' => $wellbeingdomains,
            'mapbookmarks' => $mapbookmarks,
            'block' => $blockContext->getBlock()
        );

        if ($blockContext->getSetting('mode') === 'admin') {
            return $this->renderPrivateResponse($blockContext->getTemplate(), $parameters, $response);
        }

        return $this->renderResponse($blockContext->getTemplate(), $parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'mode' => 'public',
            'title' => 'Latest News',
            'template' => 'ApplicationMap2uCoreBundle:Block:fixed_topmenu.html.twig'
        ));
    }

}
