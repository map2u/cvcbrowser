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
 * <summary>This is extend of Symfony\Component\Form\AbstractType for entity Systemparams form type</summary>
 * <purpose>Systemparams type form</purpose>
 */

namespace Yorku\JuturnaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SystemparamsType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('logo1Name')
                ->add('logo2Name')
                ->add('logo3Name')
                ->add('logo1Blob')
                ->add('logo2Blob')
                ->add('logo3Blob')
                ->add('logo1Url')
                ->add('logo2Url')
                ->add('logo3Url')
                ->add('logo1Imagetype')
                ->add('logo2Imagetype')
                ->add('logo3Imagetype')
                ->add('logo1Filename')
                ->add('logo2Filename')
                ->add('logo3Filename')
                ->add('masteremail')
                ->add('geoserverHost')
                ->add('geoserverPort')
                ->add('geoserverWorkspace');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Yorku\JuturnaBundle\Entity\Systemparams'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'yorku_juturnabundle_systemparamstype';
    }

}
