<?php

namespace Yorku\JuturnaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BirdType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('birdname')
            ->add('imageName')
            ->add('imagePath')
            ->add('description')
            ->add('websiteUrl')
            ->add('imageTip')
            ->add('user')
            ->add('station')
            ->add('enabled')
            ->add('lng')
            ->add('lat')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yorku\JuturnaBundle\Entity\Bird'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yorku_juturnabundle_bird';
    }
}
