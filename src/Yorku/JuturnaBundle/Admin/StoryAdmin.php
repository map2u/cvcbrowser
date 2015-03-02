<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class StoryAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('storyName')
                ->add('summary')
                ->add('imageFile')
                ->add('storyFile')
                ->add('email')
                ->add('theGeom')
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
                ->add('storyName')
                ->add('summary')
                ->add('imageFile')
                ->add('storyFile')
                ->add('email')
                ->add('theGeom')
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
                ->add('storyName')
                ->add('summary', 'textarea')
          //      ->add('imageFile', 'text', array('read_only' => true))
                ->add('image_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Image File'))
                ->add('story_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Story File'))
 //               ->add('storyFile')
                ->add('email')
                ->end()

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('storyName')
                ->add('summary')
                ->add('imageFile')
                ->add('storyFile')
                ->add('email')
                ->add('theGeom')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

}
