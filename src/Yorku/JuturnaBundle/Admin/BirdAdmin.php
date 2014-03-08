<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BirdAdmin extends Admin {

  /**
   * @param DatagridMapper $datagridMapper
   */
  protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
    $datagridMapper
        ->add('id')
        ->add('scientificName')
        ->add('commonName')
        ->add('iucn')
        ->add('season')
        ->add('distribution')
        ->add('rareness')
        ->add('code')
        ->add('websiteUrl')
        ->add('imageTip')
        ->add('enabled')
        ->add('lng')
        ->add('lat')
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
        ->add('scientificName')
        ->add('commonName')
        ->add('iucn')
        ->add('season')
        ->add('distribution')
        ->add('rareness')
        ->add('code')
        ->add('websiteUrl')
        ->add('imageTip')
        ->add('enabled')
        ->add('lng')
        ->add('lat')
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
        ->add('id', 'hidden')
        ->add('scientificName')
        ->add('commonName')
   //     ->add('family', 'entity', array('class' => 'Yorku\JuturnaBundle\Entity\Family'))
        ->add('user', 'entity', array('class' => 'Application\Sonata\UserBundle\Entity\User'))
        ->add('iucn', 'entity', array('class' => 'Yorku\JuturnaBundle\Entity\IUCN'))
        ->add('season', 'entity', array('class' => 'Yorku\JuturnaBundle\Entity\Season'))
        ->add('distribution', 'entity', array('class' => 'Yorku\JuturnaBundle\Entity\Distribution'))
        ->add('station', 'entity', array('class' => 'Yorku\JuturnaBundle\Entity\Station'))
        ->add('rareness', 'entity', array('class' => 'Yorku\JuturnaBundle\Entity\Rareness'))
        ->add('code')
        ->add('websiteUrl')
        ->add('imageTip')
        ->add('enabled')
        ->add('lng')
        ->add('lat')

    ;
  }

  /**
   * @param ShowMapper $showMapper
   */
  protected function configureShowFields(ShowMapper $showMapper) {
    $showMapper
        ->add('id')
        ->add('scientificName')
        ->add('commonName')
        ->add('iucn')
        ->add('season')
        ->add('distribution')
        ->add('rareness')
        ->add('code')
        ->add('websiteUrl')
        ->add('imageTip')
        ->add('enabled')
        ->add('lng')
        ->add('lat')
        ->add('theGeom')
        ->add('createdAt')
        ->add('updatedAt')
    ;
  }

}
