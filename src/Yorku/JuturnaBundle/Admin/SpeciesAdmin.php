<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SpeciesAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('code')
            ->add('speciesName')
            ->add('images')
            ->add('videos')
            ->add('audios')
            ->add('description')
            ->add('IUCN')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('code')
            ->add('speciesName')
            ->add('images')
            ->add('videos')
            ->add('audios')
            ->add('description')
            ->add('IUCN')
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
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id','hidden')
            ->add('code')
            ->add('speciesName')
            ->add('images_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Picture Files','attr'=>array("accept" => "image/*", "multiple" => "multiple")))
            ->add('videos_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Video Files','attr'=>array("accept" => "image/*", "multiple" => "multiple")))
            ->add('audios_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Audio Files','attr'=>array("accept" => "image/*", "multiple" => "multiple")))
            ->add('description')
            ->add('IUCN')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('code')
            ->add('speciesName')
            ->add('images')
            ->add('videos')
            ->add('audios')
            ->add('description')
            ->add('IUCN')
        ;
    }
}
