<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MapLayerAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('layerTitle')
            ->add('layerName')
            ->add('WMSUrl')
            ->add('geoserverWorkspace')
            ->add('geoserverLayerName')
            ->add('layerType')
            ->add('layerEnabled')
            ->add('layerShowInSwitcher')
            ->add('layerEPSG',null,array('label'=>'Layer EPSG'))
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
            ->add('layerTitle')
            ->add('layerName')
            ->add('geoserverWorkspace')
            ->add('geoserverLayerName')
            ->add('layerType')
            ->add('layerEnabled')
            ->add('layerShowInSwitcher')
            ->add('layerEPSG',null,array('label'=>'Layer EPSG'))
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
         ->with('General')
            ->add('id','hidden')
            ->add('layerTitle')
            ->add('layerName')
            ->add('WMSUrl',null,array('label'=>'WMS URL'))
            ->add('geoserverWorkspace')
            ->add('geoserverLayerName')
            ->add('layerType')
            ->add('layerEnabled')
            ->add('layerShowInSwitcher')
            ->add('layerEPSG',null,array('label'=>'Layer EPSG'))
            ->add('description')
          ->end()
          ->with('Shape File')  
                ->add('shp_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Shape File(*.shp)','attr'=>array('onchange'=>"onShapeFileSelectChange(this)")))
                ->add('shx_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Index File(*.shx)','attr'=>array('onchange'=>"onIndexFileSelectChange(this)")))
                ->add('dbf_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Database File(*.dbf)','attr'=>array('onchange'=>"onDBFFileSelectChange(this)")))
                ->add('proj_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Projection File(*.prj)'))
                ->add('epsg_code', 'text', array('required' => false, 'mapped' => false, 'label' => 'EPSG Code','attr'=>array('placeholder'=>'Default EPSG code is 4326')))
                 ->add('fieldnamelist', 'choice', array('virtual'=>true,'required' => false, 'mapped' => false, 'label' => 'Label Field Name','attr'=>array('placeholder'=>'Input the field name used as layer name','onchange'=>"onChangeFieldNameSelect(this)")))
                 ->add('overwrite_existing', 'checkbox', array('required' => false, 'mapped' => false))
                ->add('create_new_not_existing', 'checkbox', array('required' => false, 'mapped' => false, 'label' =>'Create New if Name not Exist'))
           ->end()                  
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
           ->add('layerTitle')
            ->add('layerName')
            ->add('WMSUrl')
            ->add('geoserverWorkspace')
            ->add('geoserverLayerName')
            ->add('layerType')
            ->add('layerEnabled')
            ->add('layerShowInSwitcher')
            ->add('layerEPSG',null,array('label'=>'Layer EPSG'))
             ->add('createdAt')
            ->add('updatedAt')
            ->add('description')
        ;
    }
}
