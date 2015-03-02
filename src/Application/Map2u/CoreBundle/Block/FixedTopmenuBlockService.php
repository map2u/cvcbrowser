<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
use Map2u\CoreBundle\Block\FixedTopmenuBlockService as baseFixedTopmenuBlockService;
//use Sonata\CoreBundle\Model\BaseEntityManager;
//use Sonata\DoctrineORMAdminBundle\Datagrid\Pager;
//use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Doctrine\ORM\EntityManager;
use Ibrows\Bundle\NewsletterBundle\Entity\Newsletter;

/**
 *
 * @author     Joseph Zhao jzhao@map2u.com
 */
class FixedTopmenuBlockService extends baseFixedTopmenuBlockService {

    public function __construct($name, $templating, EntityManager $entityManager) {
        parent::__construct($name, $templating, $entityManager);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {
        $criteria = array(
            'mode' => $blockContext->getSetting('mode')
        );
        
        $ecosystems = $this->em->getRepository('YorkuJuturnaBundle:EcoSystemService')->findBy(array(), array("id" => "ASC"));
        $wellbeingdomains = $this->em->getRepository('YorkuJuturnaBundle:HumanWellBeingDomain')->findBy(array(), array("id" => "ASC"));

        $parameters = array(
            'context' => $blockContext,
            'settings' => $blockContext->getSettings(),
            'ecosystems' => $ecosystems,
            'wellbeingdomains' => $wellbeingdomains,
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
