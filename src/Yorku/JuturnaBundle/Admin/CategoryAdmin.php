<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CategoryAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('name')
                ->add('slug')
                ->add('description')
                ->add('tags')
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
                ->add('name')
                ->add('slug')
              
                ->add('tags')
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
                ->with('Category', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('name')
                ->add('slug')
                //    ->add('tags')
                ->add('tags', 'entity', array(
                    'class' => 'Application\Sonata\ClassificationBundle\Entity\Tag',
                    'property' => 'name',
                    'expanded' => false,
                    'required' => false,
                    'mapped' => false,
                    'multiple' => true))
                ->end()
                ->with(' ', array('class' => 'col-md-6'))
                ->add('description', 'ckeditor', array('label' => '',
                     'required' => false,
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
                ->add('name')
                ->add('slug')
                ->add('description')
                ->add('tags')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

}
