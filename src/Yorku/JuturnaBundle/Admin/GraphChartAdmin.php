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
 * <purpose>custom the GraphChart entity form for Sonata\AdminBundle\Admin\Admin</purpose>
 */

namespace Yorku\JuturnaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class GraphChartAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('citation')
                ->add('citationLink')
                ->add('graphchartName')
                ->add('graphchartTitle')
                ->add('graphchartImages')
                ->add('tags')
                ->add('description')
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
                ->add('citation')
                ->add('citationLink')
                ->add('graphchartName')
                ->add('graphchartTitle')
                ->add('graphchartImages')
                ->add('tags')
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
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Graph and Chart', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('graphchartName')
                ->add('graphchartTitle')
                ->add('citation')
                ->add('citationLink')
                ->add('categories')
                //->add('category_choice', 'choice', array('multiple' => true, 'mapped' => false,'choices' => array('freedom_choice' => 'Freedom Choice', 'cultural_services' => 'Cultural Services', 'regulating_services' => 'Regulating Services', 'provsional_services' => 'Provsional Services', 'good_social_relations' => 'Good Social Relations', 'basic_materials' => 'Basic Materials', 'security' => 'Security', 'health_well_being' => 'Health and Wellbeing')))
                ->add('graphchartImages_file', 'file', array('required' => false, 'multiple' => true, 'mapped' => false, 'attr' => array('accept' => 'image/*')))
                ->end()
                ->with(' ', array('class' => 'col-md-6'))
                ->add('tags')
//                ->add('tags_choice', 'entity', array(
//                    'class' => 'Application\Sonata\ClassificationBundle\Entity\Tag',
//                    'property' => 'name',
//                    'expanded' => false,
//                    'mapped' => false,
//                    'multiple' => true))
                //     ->add('tags', 'collection', array('type' => 'choice', 'options' => array('choices' => array('freedom_choice' => 'Freedom Choice', 'cultural_services' => 'Cultural Services', 'regulating_services' => 'Regulating Services'), 'multiple' => true, 'label' => 'Select Tags'), 'allow_add' => true, 'delete_empty' => true)) //Application\Sonata\ClassificationBundle\Entity\Tag
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
                ->add('citation')
                ->add('citationLink')
                ->add('graphchartName')
                ->add('graphchartTitle')
                ->add('graphchartImages')
                ->add('tags')
                ->add('description')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

}
