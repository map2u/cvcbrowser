<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
namespace Map2u\WebBundle\Menu;
 
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
 
class MenuBuilder extends ContainerAware
{
    public function FixedTopMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
 
        $menu->addChild('System Help', array('route' => '_welcome'))
            ->setAttribute('icon', 'icon-help');
 
        $menu->addChild('Employees', array('route' => '_welcome'))
            ->setAttribute('icon', 'icon-group');
 
        return $menu;
    }
    
     public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
 
        $menu->addChild('Projects', array('route' => '_welcome'))
            ->setAttribute('icon', 'icon-list');
 
        $menu->addChild('Employees', array('route' => '_welcome'))
            ->setAttribute('icon', 'icon-group');
 
        return $menu;
    }
   
    public function superdemographicsMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
 
        $menu->addChild('Projects', array('route' => '_welcome'))
            ->setAttribute('icon', 'icon-list');
 
        $menu->addChild('Employees', array('route' => '_welcome'))
            ->setAttribute('icon', 'icon-group');
 
        return $menu;
    }
    
 public function mainMenu2(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
 
        $menu->addChild('User')
             ->setAttribute('dropdown', true);
 
        $menu['User']->addChild('Profile', array('uri' => '#'))
                     ->setAttribute('divider_append', true);
        $menu['User']->addChild('Logout', array('uri' => '#'));
 
        $menu->addChild('Language')
             ->setAttribute('dropdown', true)
             ->setAttribute('divider_prepend', true);
 
        $menu['Language']->addChild('Deutsch', array('uri' => '#'));
        $menu['Language']->addChild('English', array('uri' => '#'));
 
        return $menu;
    }
    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
 
        /*
        You probably want to show user specific information such as the username here. That's possible! Use any of the below methods to do this.
 
        if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {} // Check if the visitor has any authenticated roles
        $username = $this->container->get('security.context')->getToken()->getUser()->getUsername(); // Get username of the current logged in user
 
        */    
        $menu->addChild('User', array('label' => 'Hi visitor'))
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'icon-user');
 
        $menu['User']->addChild('Edit profile', array('route' => '_welcome'))
            ->setAttribute('icon', 'icon-edit');
 
        return $menu;
    }
}