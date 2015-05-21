<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CategoryContentsAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('title')
                ->add('detail')
                ->add('layerId')
                ->add('citation')
                ->add('citationLink')
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
                ->add('title')
                ->add('detail')
                ->add('layerId')
                ->add('citation')
                ->add('citationLink')
                ->add('description')
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
                ->with('Category Content', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('title')
                ->add('category', 'entity', array('label' => 'Category',
                    'required' => true,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\Category',
                    'property' => 'name',
                    'multiple' => false
                ))
                ->add('layer', 'entity', array('label' => 'Map Layer',
                    'required' => true,
                    'expanded' => false,
                    'class' => 'Map2u\CoreBundle\Entity\UploadfileLayer',
                    'property' => 'layerName',
                    'multiple' => false
                ))
                ->add('displayLayers', 'entity', array('label' => 'Display Map Layers',
                    'required' => true,
                    'expanded' => false,
                    'class' => 'Map2u\CoreBundle\Entity\UploadfileLayer',
                    'property' => 'layerName',
                    'multiple' => true
                ))
                ->add('tags', 'entity', array(
                    'class' => 'Application\Sonata\ClassificationBundle\Entity\Tag',
                    'property' => 'name',
                    'expanded' => false,
                    'mapped' => false,
                    'multiple' => true))
                ->add('detail', 'ckeditor', array('label' => '',
                    'config_name' => 'forums',
                    'config' => array('uiColor' => '#ffffff')
                ))
                ->end()
                ->with(' ', array('class' => 'col-md-6'))
                ->add('position')
                ->add('citation')
                ->add('citationLink')
                ->add('description')
                ->end()

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('title')
                ->add('detail')
                ->add('layerId')
                ->add('citation')
                ->add('citationLink')
                ->add('description')
                ->add('tags')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

}
