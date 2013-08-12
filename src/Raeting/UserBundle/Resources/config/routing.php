<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('login', 
    new Route('/login', array(
        '_controller' => 'RaetingUserBundle:User:simpleLogin'
    )
));

$collection->add('login_check', new Route('/login_check', array()));
$collection->add('logout', new Route('/logout', array()));

$collection->add('user.register', new Route('/register', array(
    '_controller' => 'RaetingUserBundle:User:register',
)));

$collection->add('user.register_success', new Route('/registration-successful', array(
    '_controller' => 'RaetingUserBundle:User:registerSuccess',
)));

$collection->add('user.recover', new Route('/recover-password', array(
    '_controller' => 'RaetingUserBundle:User:recover',
)));

$collection->add('user.change_password', new Route('/change-password', array(
    '_controller' => 'RaetingUserBundle:User:changePassword',
)));

$collection->add('user.profile_edit', new Route('/user/edit', array(
    '_controller' => 'RaetingUserBundle:User:edit',
)));

$collection->add('user.profile', new Route('/user', array(
    '_controller' => 'RaetingUserBundle:User:index',
)));

$collection->add('user.new_password', new Route('/new-password', array(
    '_controller' => 'RaetingUserBundle:User:newPassword',
)));

$collection->add('traders', new Route('/traders', array(
    '_controller' => 'RaetingUserBundle:User:list',
)));


return $collection;
