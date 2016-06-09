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
 * <purpose>custom the Story entity form for Sonata\AdminBundle\Admin\Admin</purpose>
 */

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class StoryAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('storyName')
                ->add('summary')
                ->add('imageFile')
                ->add('storyFile')
                ->add('email')
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
                ->add('storyName')
                ->add('email')
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
                ->with('Story', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('storyName')
                ->add('storyType', 'entity', array('label' => 'Story Type',
                    'required' => true,
                    'expanded' => false,
                    'class' => 'Map2u\CoreBundle\Entity\StoryType',
                    'property' => 'name',
                    'multiple' => false
                ))
                ->add('summary', 'textarea')
                //      ->add('imageFile', 'text', array('read_only' => true))
                ->add('image_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Image File'))
                ->add('story_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Story File(current support pdf and html file)'))
                //               ->add('storyFile')
                ->add('email')
                ->end()
                ->with('Story Content', array('class' => 'col-md-6'))
                ->add('storyText', 'ckeditor', array('label' => 'Story Content',
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
                ->add('storyName')
                ->add('summary')
                ->add('imageFile')
                ->add('storyFile')
                ->add('email')
                ->add('theGeom')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

}
