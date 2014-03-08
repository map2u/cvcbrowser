<?php

namespace Yorku\JuturnaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LogoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imagename')
            ->add('imageFilename')
            ->add('description')
            ->add('websiteUrl')
            ->add('imageTip')
            ->add('enabled')
            ->add('showSeq')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yorku\JuturnaBundle\Entity\Logo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yorku_juturnabundle_logo';
    }
}
