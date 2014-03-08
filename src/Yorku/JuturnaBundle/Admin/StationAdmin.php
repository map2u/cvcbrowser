<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class StationAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('stationName')
            ->add('code')
            ->add('geometryType')
            ->add('radius')
            ->add('intersection')
            ->add('description')
          
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('stationName')
            ->add('code')
            ->add('lng')
            ->add('lat')
            ->add('radius')
            ->add('intersection')
            ->add('description')
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
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id','hidden')
            ->add('stationName')
            ->add('code')
            ->add('lng')
            ->add('lat')
            ->add('radius')
            ->add('intersection')
            ->add('description')
           
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('stationName')
            ->add('code')
            ->add('geometryType')
            ->add('theGeom')
            ->add('radius')
            ->add('intersection')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
