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
 * <date>created at 2014/01/07</date>
 * <date>last updated at 2015/05/21</date>
 * <summary>This file is supposed display to indicators in a page column</summary>
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

class IndicatorColumnBlockService extends BaseBlockService {

    // by service to get the object of entity manager
    protected $em;

    // pass parameters when creating service
    public function __construct($name, $templating, EntityManager $entityManager) {
        parent::__construct($name, $templating);
        $this->em = $entityManager;
    }

    /**
     *  
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
            'criteria' => $criteria,
            'block' => $blockContext->getBlock()
        );

        if ($blockContext->getSetting('mode') === 'admin') {
            return $this->renderPrivateResponse($blockContext->getTemplate(), $parameters, $response);
        }

        return $this->renderResponse($blockContext->getTemplate(), $parameters, $response);
    }

    /**
     * return service name
     */
    public function getName() {
        return 'Indicator Column';
    }

    /**
     * set default settings
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'mode' => 'public',
            'title' => 'Indicators',
            'template' => 'YorkuJuturnaBundle:Block:indicator_column.html.twig'
        ));
    }

}
