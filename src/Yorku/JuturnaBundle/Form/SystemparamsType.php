<?php

namespace Yorku\JuturnaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SystemparamsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yorku\JuturnaBundle\Entity\Systemparams'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yorku_juturnabundle_systemparamstype';
    }
}
