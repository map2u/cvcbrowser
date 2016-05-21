<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yorku\JuturnaBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\CoreBundle\Model\ManagerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Sonata\CoreBundle\Model\BaseEntityManager;
//use Sonata\DoctrineORMAdminBundle\Datagrid\Pager;
//use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Doctrine\ORM\EntityManager;

/**
 *
 * @author     Joseph Zhao jzhao@map2u.com
 */
class PageHeaderContentBlockService extends BaseBlockService {

    private $em;

    public function __construct($name, $templating, EntityManager $entityManager) {
        parent::__construct($name, $templating);
        $this->em = $entityManager;
    }

   
    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {

        $settings = $blockContext->getSettings();

        $criteria = array(
            'mode' => $settings['mode']
        );
     //   $blockContext->setSetting('template', 'Map2uCoreBundle:Block:page_header_content.html.twig');

        $parameters = array(
      //      'mode' => 'public',
            'settings' => $settings,
            'block' => $blockContext->getBlock(),
            'logos' => $this->getLogos($criteria, 1)
        );

        if ($settings['mode'] === 'admin') {
            return $this->renderPrivateResponse($blockContext->getTemplate(), $parameters, $response);
        }

        return $this->renderResponse($blockContext->getTemplate(), $parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {
        // TODO: Implement validateBlock() method.
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block) {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('locale', 'string', array('required' => true)),
                array('title', 'text', array('required' => false)),
                array('mode', 'choice', array(
                        'required' => false,
                        'choices' => array(
                            'public' => 'public',
                            'admin' => 'admin'
                        )
                    ))
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'Page Header Block';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'mode' => 'public',
            'title' => 'Header Block',
            'template' => 'Map2uCoreBundle:Block:page_header_content.html.twig'
        ));
        $this->configureSettings($resolver);
    }


    public function configureSettings(\Symfony\Component\OptionsResolver\OptionsResolver $optionsResolver) {
        // defaults for all blocks
//        $optionsResolver->setDefaults(array(
//            'mode' => 'public',
//        ));
//
//        // TODO: Remove it when bumping requirements to SF 2.6+
//        if (method_exists($optionsResolver, 'setDefined')) {
//            $optionsResolver
//                    ->addAllowedTypes('mode', 'string')
//
//            ;
//        } else {
//            $optionsResolver->addAllowedTypes(array(
//                'mode' => array('string'),
//            ));
//        }
//
//        parent::configureSettings($optionsResolver);
        $optionsResolver->setDefaults(array(
            'mode' => 'public',
            'title' => 'Header Block',
            'template' => 'Map2uCoreBundle:Block:page_header_content.html.twig'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getLogos(array $criteria, $page, $maxPerPage = 10) {
        if (!isset($criteria['mode'])) {
            $criteria['mode'] = 'public';
        }

        $parameters = array();
        $limit = 5;
        $query = $this->em->getRepository('Map2u\CoreBundle\Entity\Logo')
                ->createQueryBuilder('p')
                ->select('p')
                ->setMaxResults($limit)
                ->orderby('p.showSeq', 'ASC');

        if ($criteria['mode'] == 'public') {
            // enabled
            $criteria['enabled'] = isset($criteria['enabled']) ? $criteria['enabled'] : true;
            $query->andWhere('p.enabled = :enabled');
            $parameters['enabled'] = $criteria['enabled'];
        }


        $query->setParameters($parameters);

        return $query->getQuery()->getResult();
    }

}
