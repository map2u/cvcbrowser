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
 * <summary>This is the extend of Sonata\AdminBundle\Admin\Admin</summary>
 * <purpose>custom the IndicatorBenefit entity form for Sonata\AdminBundle\Admin\Admin</purpose>
 */

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class IndicatorBenefitAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
               
                ->add('benefitName')
                ->add('title')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
               
                ->add('benefitName')
                ->add('title')
                ->add('layers')
                
                ->add('createdAt')
                ->add('updatedAt')
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Indicator Benefit', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('benefitName')
                ->add('title')
                ->add('indicator', 'entity', array('required' => true,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\Indicator',
                    'property' => 'name',
                    'multiple' => false
                        )
                )
                ->add('layers', 'entity', array('required' => false,
                    'expanded' => false,
                    'class' => 'Map2u\CoreBundle\Entity\Layer',
                    'property' => 'name',
                    'multiple' => true
                        )
                )
               
                ->add('ecosystemservices', 'entity', array('required' => true,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\EcoSystemService',
                    'property' => 'name',
                    'multiple' => true
                        )
                )
                ->add('humanwellbeingedomains', 'entity', array('required' => true,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\HumanWellBeingDomain',
                    'property' => 'name',
                    'multiple' => true
                        )
                )
                ->add('indicatorreferences', 'entity', array('required' => false,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\IndicatorReference',
                    'property' => 'name',
                    'multiple' => true
                        )
                )
                ->add('additionalreferences', 'entity', array('required' => false,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\IndicatorReference',
                    'property' => 'name',
                    'multiple' => true
                        )
                )
                ->add('otherlinks', 'entity', array('required' => false,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\IndicatorReference',
                    'property' => 'name',
                    'multiple' => true
                        )
                )
                ->add('indicatorbenefitimages', 'entity', array('required' => false,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\IndicatorBenefitImage',
                    'property' => 'imageName',
                    'multiple' => true
                        )
                )
                ->end()
                ->with('Brief Report', array('class' => 'col-md-6'))
                ->add('abstract', 'textarea')
                ->add('briefReport', 'ckeditor', array('label' => '',
                    'config_name' => 'forums',
                    'config' => array('uiColor' => '#ffffff')
                ))
                ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('benefitName')
                ->add('title')
                ->add('abstract')
                ->add('briefReport')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

}
