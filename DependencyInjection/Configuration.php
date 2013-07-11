<?php
namespace Oxygen\PassbookBundle\DependencyInjection;

use Oxygen\FrameworkBundle\DependencyInjection\OxygenConfiguration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends OxygenConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('oxygen_passbook');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        
        $this->addEntityConfiguration($rootNode, 'Oxygen\PassbookBundle\Entity\Event', 'Oxygen\PassbookBundle\Entity\Repository\EventRepository');

        return $treeBuilder;
    }
}
