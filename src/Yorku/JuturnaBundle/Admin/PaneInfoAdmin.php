<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PaneInfoAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('paneInfoType')
                ->add('title')

        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('title')
            
                ->add('paneInfoType')
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
                ->with('Pane Info', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('title')
                ->add('paneInfoType', 'entity', array('label' => 'Pane Info Type',
                    'required' => true,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\PaneInfoType',
                    'property' => 'name',
                    'multiple' => false
                ))
                ->add('content', 'ckeditor', array('label' => 'Content',
                    'required' => true,
                    'config_name' => 'forums',
                    'config' => array('uiColor' => '#ffffff')))
                ->end();


        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('title')
                ->add('content')
                ->add('paneInfoType')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

}
