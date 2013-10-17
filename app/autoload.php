<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var $loader ClassLoader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$loader->addClassMap(array(
    'PHPExcel' => __DIR__.'/../vendor/phpexcel/phpexcel/Classes/PHPExcel.php'
));

return $loader;
