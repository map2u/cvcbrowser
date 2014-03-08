<?php

namespace Yorku\JuturnaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('cryptedPassword')
            ->add('resetPasswordToken')
            ->add('resetPasswordSentAt')
            ->add('rememberCreatedAt')
            ->add('signInCount')
            ->add('currentSignInAt')
            ->add('lastSignInAt')
            ->add('currentSignInIp')
            ->add('lastSignInIp')
            ->add('confirmationToken')
            ->add('confirmedAt')
            ->add('confirmationSentAt')
            ->add('unconfirmedEmail')
            ->add('failedAttempts')
            ->add('unlockToken')
            ->add('lockedAt')
            ->add('rememberToken')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('phoneNumber')
            ->add('address')
            ->add('postalCode')
            ->add('reason')
            ->add('acceptterms')
            ->add('salt')
            ->add('status')
            ->add('rememberTokenExpiresAt')
            ->add('registIp')
            ->add('activationCode')
            ->add('deletedAt')
            ->add('activatedAt')
            ->add('groupnameId')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yorku\JuturnaBundle\Entity\Users'
        ));
    }

    public function getName()
    {
        return 'yorku_juturnabundle_userstype';
    }
}
