<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('index',
    new Route('/', array('_controller' => 'RaetingCoreBundle:Home:index')));

$collection->add('home', new Route('/{lang}', array(
    '_controller' => 'RaetingCoreBundle:Home:home',
), array(
    'lang'    => ROUTE_LANGUAGES,
    '_scheme' => 'http'
)));

$collection->add('newsletter.subscribe',
    new Route('/{lang}/newsletter-subscribe', array('_controller' => 'RaetingCoreBundle:Newsletter:subscribe')));


$collection->add('city.autocomplete', new Route('/{lang}/city/autocomplete', array(
    '_controller' => 'RaetingCoreBundle:City:autocomplete',
), array(
    'lang'    => ROUTE_LANGUAGES,
    '_scheme' => 'http'
)));

$collection->add('country.autocomplete', new Route('/{lang}/country/autocomplete', array(
    '_controller' => 'RaetingCoreBundle:Country:autocomplete',
), array(
    'lang'    => ROUTE_LANGUAGES,
    '_scheme' => 'http'
)));


return $collection;
