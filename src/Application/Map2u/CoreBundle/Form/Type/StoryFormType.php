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
 * <summary>This is extend of Symfony\Component\Form\AbstractType for entity MapBookmark form type</summary>
 * <purpose>custom MapBookmark form type</purpose>
 */

namespace Application\Map2u\CoreBundle\Form\Type;

use FOS\UserBundle\Form\DataTransformer\UserToUsernameTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form type for representing a UserInterface instance by its username string.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class StoryFormType extends AbstractType {

    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class) {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('storyName')
                ->add('storyType', 'entity', array('label' => 'Story Type',
                    'required' => true,
                    'expanded' => false,
                    'class' => 'Map2u\CoreBundle\Entity\StoryType',
                    'property' => 'name',
                    'multiple' => false
                ))
                ->add('summary', 'textarea')
                ->add('storyText', 'ckeditor', array('label' => 'Story Content',
                    'required' => false,
                    'config_name' => 'basic',
                    'config' => array('uiColor' => '#ffffff')
                ))
                ->add('image_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Image File'))
                ->add('story_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Story File(current support pdf and html file)'))
                //               ->add('storyFile')
                ->add('email')
                ->add('submit', 'submit');

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'map2u_story',
        ));
    }

    public function getName() {
        return 'map2u_story';
    }

}
