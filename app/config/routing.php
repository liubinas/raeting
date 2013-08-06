<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();


if (!defined('CHECKOUT_SCHEME')) {
    define('CHECKOUT_SCHEME', 'https');
}

//Add bundles below.
$collection->addCollection($loader->import("@RaetingUserBundle/Resources/config/routing.php"));

$collection->add('_internal', new Route('/_internal/{controller}/{path}.{_format}', array(
    '_controller' => 'FrameworkBundle:Internal:index',
), array(
     'path' => '.+',
     '_format' => '[^.]+'
)));

return $collection;
