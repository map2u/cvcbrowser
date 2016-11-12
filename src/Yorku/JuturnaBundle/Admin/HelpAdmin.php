<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HelpAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('fileName')
                ->add('fileType')
                ->add('active')
                ->add('updatedAt')
                ->add('content')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('helpType')
                ->add('fileName')
                ->add('fileType')
                ->add('active')
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
                ->with('Help System Content')
                ->add('id', 'hidden')
                ->add('fileName', 'text', array('read_only' => true))
                ->add('help_file', 'file', array('label' => 'Help File:', 'mapped' => false, 'required' => false,'attr'=>array("onchange"=>"app.updateHelpFileContent(this);")))
                ->add('zip_file', 'file', array('label' => 'Zipped Image File:', 'mapped' => false, 'required' => false))
  
                ->add('active', ChoiceType::class, array('choices' => array( true=>'Yes', false=> 'No')))
                ->add('helpType', 'entity', array(
                    'class' => 'Yorku\JuturnaBundle\Entity\HelpType',
                    'property' => 'name',
                    'expanded' => false,
                    'required' => true,
                    'multiple' => false))
                ->add('content', 'ckeditor', array('label' => 'Help Content',
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
                ->add('fileName')
                ->add('fileType')
                ->add('active')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('content')
        ;
    }

}
