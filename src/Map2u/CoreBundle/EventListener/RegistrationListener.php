<?php

// src/Acme/DemoBundle/EventListener/RegistrationListener.php

namespace Map2u\CoreBundle\EventListener;

use FOSUserBundle\FOSUserEvents;
use FOSUserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listener responsible for adding the default user role at registration
 */
class RegistrationListener implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(FormEvent $event) {
        $rolesArr = array('ROLE_VOLUNTEER');
        /** @var $user \FOS\UserBundle\Model\UserInterface */
        $user = $event->getForm()->getData();
        $user->setRoles($rolesArr);
    }

    public function onAddDefaultRoleSuccess(FilterUserResponseEvent $event) {
        $doctrine = $this->container->get('doctrine');
        $em = $doctrine->getManager();
        $users = $em->getRepository('YorkuJuturnaBundle:Users')->findAll();

        $user = $event->getUser();
        if ($users->length < 5)
            $user->addRole('ROLE_VOLUNTEER');
        else
            $user->addRole('ROLE_ADMINISTRATOR');

        $em->persist($user);
        $em->flush();
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
