<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('index',
    new Route('/', array('_controller' => 'RaetingCoreBundle:Home:index')));



return $collection;
