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
 * <purpose>custom the UserDrawGeometries entity form for Sonata\AdminBundle\Admin\Admin</purpose>
 */

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
                ->add('updatedAt')
                ->add('images')
                ->add('altText')
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
                ->add('altText')
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
                ->add('altText')
                ->add('video')
                ->add('audio')
        ;
    }

}
