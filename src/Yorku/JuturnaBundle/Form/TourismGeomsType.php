<?php

namespace Yorku\JuturnaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TourismGeomsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('label')
            ->add('icon')
            ->add('isPublished')
            ->add('radius')
            ->add('geometry','hidden',array('required' => false, 'mapped' => false))
        
            ->add('style_file','file',array('required' => false, 'mapped' => false, 'label' => 'Style  File','attr'=>array("accept" => "image/*", "multiple" => false)))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yorku\JuturnaBundle\Entity\TourismGeoms'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yorku_juturnabundle_tourismgeoms';
    }
}
