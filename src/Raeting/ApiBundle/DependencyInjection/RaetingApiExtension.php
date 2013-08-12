<?php

namespace Raeting\ApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class RaetingApiExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * Canonical name
     * 
     * @return string
     */
    public function getAlias()
    {
        return 'raeting_api';
    }
}
