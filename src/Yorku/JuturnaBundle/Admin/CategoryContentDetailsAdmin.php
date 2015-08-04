<?php

/**
 * <copyright>
 * This file/program is free and open source software released under the GNU General Public
 * License version 3, and is distributed WITHOUT ANY WARRANTY. A copy of the GNU General
 * Public Licence is available at http://www.gnu.org/licenses
 * </copyright>
 *
 * <author>Shuilin (Joseph) Zhao</author>
 * <company>SpEAR Lab, Faculty of Environmental Studies, York University
 * <email>zhaoshuilin2004@yahoo.ca</email>
 * <date>created at 2014/01/06</date>
 * <date>last updated at 2015/03/11</date>
 * <summary>This is the extend of Sonata\AdminBundle\Admin\Admin</summary>
 * <purpose>custom the CategoryContentDetails entity form for Sonata\AdminBundle\Admin\Admin</purpose>
 */

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CategoryContentDetailsAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('detail')
                ->add('position')
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
                ->add('detail')
                ->add('position')
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
                ->with('Category Content Detail', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('categorycontent', 'entity', array('label' => 'Content Titile',
                    'required' => true,
                    'expanded' => false,
                    'class' => 'Yorku\JuturnaBundle\Entity\CategoryContents',
                    'property' => 'title',
                    'multiple' => false
                ))
                ->add('position')
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
                ->add('detail')
                ->add('position')
                ->add('citation')
                ->add('citationLink')
                ->add('description')
                ->add('tags')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

}
