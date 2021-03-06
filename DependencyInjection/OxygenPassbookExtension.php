<?php

namespace Oxygen\PassbookBundle\DependencyInjection;

use Oxygen\FrameworkBundle\DependencyInjection\OxygenExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class OxygenPassbookExtension extends OxygenExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $container->setParameter('oxygen_passbook.event_types', $config['event_types']);
        $this->mapsEntitiesParameter($container, 'oxygen_passbook', $config);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services/event.xml');
        $loader->load('services/booking.xml');
        $loader->load('services/printing.xml');
        $loader->load('services/validators.xml');
    }
}
