<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class IndicatorBenefitImageAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('imageName')
                ->add('imageTitle')
                ->add('fileName')

        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('id')
                ->add('imageName')
                ->add('imageTitle')
                ->add('indicator')
                ->add('fileName')
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
                ->with('Indicator Benefit Images', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('imageName')
                ->add('imageTitle')
                ->add('imageCaption')
                ->add('indicator', 'entity', array('required' => true,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\Indicator',
                    'property' => 'name',
                    'multiple' => false
                ))
                ->add('image_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Image Files'))
                ->add('description', 'textarea', array('required' => false))
                ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('imageName')
                ->add('imageTitle')
                ->add('imageCaption')
                ->add('indicator')
                ->add('fileName')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

}
