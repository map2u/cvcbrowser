<?php

namespace Yorku\JuturnaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('message','textarea',array('attr'=>array('rows' => 7 , 'cols' => 30)))

            ->add('name')
 
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yorku\JuturnaBundle\Entity\Contact'
        ));
    }

    public function getName()
    {
        return 'yorku_juturnabundle_contacttype';
    }
}
