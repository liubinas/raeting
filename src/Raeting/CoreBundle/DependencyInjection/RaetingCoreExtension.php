<?php

namespace Raeting\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class RaetingCoreExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = array();
        foreach ($configs as $cfg) {
            $config = array_merge($config, $cfg);
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $container->setParameter('core.web_directory_path', $config['web_directory_path']);
        $container->setParameter('core.js_path', $config['js_path']);
        $container->setParameter('core.upload_directory_path', $config['upload_directory_path']);
        $container->setParameter('core.exception_listener.controller', $config['exception_listener']['controller']);   

        $loader->load('core.xml');
        $loader->load('services.xml');
    }

    /**
     * Canonical name
     * 
     * @return string
     */
    public function getAlias()
    {
        return 'raeting_core';
    }
}
