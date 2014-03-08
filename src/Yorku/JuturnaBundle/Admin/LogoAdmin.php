<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LogoAdmin extends Admin {

  /**
   * @param DatagridMapper $datagridMapper
   */
  protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
    $datagridMapper
        ->add('id')
        ->add('imagename')
        ->add('imageFilename')
        ->add('imagePath')
        ->add('description')
        ->add('websiteUrl')
        ->add('imageTip')
        ->add('enabled')
        ->add('showSeq')
    ;
  }

  /**
   * @param ListMapper $listMapper
   */
  protected function configureListFields(ListMapper $listMapper) {
    $listMapper
        ->add('id')
        ->add('imagename')
        ->add('imageFilename')
        ->add('websiteUrl')
        ->add('enabled')
        ->add('showSeq')
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
        ->add('id', 'hidden')
        ->add('imagename')
        ->add('image_file', 'file', array('required' => false,  'mapped' => false, 'label' => 'Image File'))
        ->add('description')
        ->add('websiteUrl')
        ->add('imageTip')
        ->add('enabled')
        ->add('showSeq')
    ;
  }

  /**
   * @param ShowMapper $showMapper
   */
  protected function configureShowFields(ShowMapper $showMapper) {
    $showMapper
        ->add('id')
        ->add('imagename')
        ->add('imageFilename')
        ->add('imagePath')
        ->add('description')
        ->add('websiteUrl')
        ->add('imageTip')
        ->add('enabled')
        ->add('showSeq')
        ->add('createdAt')
        ->add('updatedAt')
    ;
  }

}
