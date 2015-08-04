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
 * <summary>This file is created extend of Sonata\BlockBundle\Block\BaseBlockService with bundle YorkuJuturnaBundle</summary>
 * <purpose>set indicator display block with indicator_column.html.twig</purpose>
 *  
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
use Map2u\CoreBundle\Block\FixedTopmenuBlockService as baseFixedTopmenuBlockService;
use Doctrine\ORM\EntityManager;
use Ibrows\Bundle\NewsletterBundle\Entity\Newsletter;

/**
 *
 * @author     Joseph Zhao jzhao@map2u.com
 */
class IndicatorColumnBlockService extends BaseBlockService {

    protected $em;

    public function __construct($name, $templating, EntityManager $entityManager) {
        parent::__construct($name, $templating);
        $this->em = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {
        $criteria = array(
            'mode' => $blockContext->getSetting('mode')
        );

        $indicators = $this->em->getRepository('YorkuJuturnaBundle:Indicator')->findBy(array(), array("id" => "ASC"));

        $parameters = array(
            'context' => $blockContext,
            'settings' => $blockContext->getSettings(),
            'indicators' => $indicators,
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
    public function getName() {
        return 'Indicator Column';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'mode' => 'public',
            'title' => 'Indicators',
            'template' => 'YorkuJuturnaBundle:Block:indicator_column.html.twig'
        ));
    }

}
