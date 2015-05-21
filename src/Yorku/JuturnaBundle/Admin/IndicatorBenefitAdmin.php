<?php

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
                ->add('id')
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
                ->add('id')
                ->add('benefitName')
                ->add('title')
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
                ->add('uploadfilelayers', 'entity', array('required' => false,
                    'expanded' => false,
                    'class' => 'Map2u\CoreBundle\Entity\UploadfileLayer',
                    'property' => 'layerTitle',
                    'multiple' => true
                        )
                )
                ->add('clusterlayers', 'entity', array('required' => false,
                    'expanded' => false,
                    'class' => 'Map2u\CoreBundle\Entity\LeafletClusterLayer',
                    'property' => 'layerTitle',
                    'multiple' => true
                        )
                )
                ->add('geoserverlayers', 'entity', array('required' => false,
                    'expanded' => false,
                    'class' => 'Map2u\CoreBundle\Entity\GeoServerLayer',
                    'property' => 'layerTitle',
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
