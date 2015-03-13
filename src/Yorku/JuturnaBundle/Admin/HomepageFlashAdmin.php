<?php

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class HomepageFlashAdmin extends Admin {

    private $container = null;

    public function __construct($code, $class, $baseControllerName, $container = null) {
        parent::__construct($code, $class, $baseControllerName);
        $this->container = $container;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('title')
                ->add('introduce')
                ->add('image')
                ->add('url')
                ->add('published')
                ->add('active')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('description')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('id')
                ->add('title')
                ->add('introduce')
                ->add('image')
                ->add('url')
                ->add('published')
                ->add('active')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('description')
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
                ->with('Homepage Flash', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('title')
                ->add('category', 'entity', array('label' => 'Category',
                    'required' => true,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\Category',
                    'property' => 'name',
                    'multiple' => false
                ))
                ->add('introduce')
                ->add('image_file', 'file', array('label' => 'Image Files:', 'mapped' => false,'required'=>false))
                ->add('url')
                ->add('published')
                ->add('active')
                ->add('alignLeft')
                ->add('titleMargin')
                ->end()
                ->with('Homepage Flash Description', array('class' => 'col-md-6'))
                ->add('description', 'ckeditor', array('label' => 'Description Content','required'=>false,
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
                ->add('title')
                ->add('introduce')
                ->add('image')
                ->add('url')
                ->add('published')
                ->add('active')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('description')
        ;
    }

}
