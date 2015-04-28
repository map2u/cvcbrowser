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
                ->add('title')
                ->add('flashimage_files', 'file', array('label' => 'Flash Image Files:', 'mapped' => false, 'required' => false, 'attr' => array('multiple' => true)))
                ->add('meadiagram_file', 'file', array('label' => 'Mea Diagram File:', 'mapped' => false, 'required' => false))
                ->add('slug')
                ->add('tags', 'entity', array(
                    'class' => 'Application\Sonata\ClassificationBundle\Entity\Tag',
                    'property' => 'name',
                    'expanded' => false,
                    'required' => false,
                    'mapped' => false,
                    'multiple' => true))
                ->add('rightColumnWidth', 'choice', array("required" => false, "choices" => array(2 => "2/10 page width",3 => "3/10 page width", 4 => "4/10 page width", 5 => "5/10 page width", 6 => "6/10 page width", 7 => "7/10 page width", 8 => "8/10 page width")))
                ->end()
                ->with(' ', array('class' => 'col-md-6'))
                ->add('rightColumn', 'ckeditor', array('label' => 'Right Column Content(page right column)',
                    'required' => false,
                    'config_name' => 'forums',
                    'config' => array('uiColor' => '#ffffff')
                ))
                ->add('description', 'ckeditor', array('label' => 'Description(page left column)',
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
