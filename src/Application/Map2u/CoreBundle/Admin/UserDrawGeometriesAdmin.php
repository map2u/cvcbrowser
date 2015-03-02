<?php

namespace Application\Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserDrawGeometriesAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('userId')
                ->add('userdrawlayerId')
                ->add('name')
                ->add('geomType')
                ->add('radius')
                ->add('buffer')
                ->add('markerIcon')
                ->add('public')
                ->add('description')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('images')
                ->add('video')
                ->add('audio')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('id')
                ->add('userId')
                ->add('userdrawlayerId')
                ->add('name')
                ->add('geomType')
                ->add('radius')
                ->add('buffer')
                ->add('markerIcon')
                ->add('public')
                ->add('description')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('images')
                ->add('video')
                ->add('audio')
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
                ->add('user', 'entity', array('class' => 'Application\Sonata\UserBundle\Entity\User'))
                ->add('userdrawlayer', 'entity', array('class' => 'Map2u\CoreBundle\Entity\UserDrawLayer'))
                ->add('name')
                ->add('geomType')
                ->add('radius')
                ->add('buffer')
                ->add('markerIcon')
                ->add('public')
                ->add('description')
                ->add('images')
                ->add('video')
                ->add('audio')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('userId')
                ->add('userdrawlayerId')
                ->add('name')
                ->add('geomType')
                ->add('radius')
                ->add('buffer')
                ->add('markerIcon')
                ->add('public')
                ->add('description')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('images')
                ->add('video')
                ->add('audio')
        ;
    }

}
