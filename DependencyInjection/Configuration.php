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
        
        //$rootNode->children()
        
        $this->addEntityConfiguration($rootNode, 'Oxygen\PassbookBundle\Entity\Event', 'Oxygen\PassbookBundle\Entity\Repository\EventRepository');
        $this->addEntityConfiguration($rootNode, 'Oxygen\PassbookBundle\Entity\EventProduct', 'Oxygen\PassbookBundle\Entity\Repository\EventProductRepository');
        $this->addEntityConfiguration($rootNode, 'Oxygen\PassbookBundle\Entity\EventTicket', 'Oxygen\PassbookBundle\Entity\Repository\EventTicketRepository');
        $this->addEntityConfiguration($rootNode, 'Oxygen\PassbookBundle\Entity\EventProductSlot', 'Oxygen\PassbookBundle\Entity\Repository\EventProductSlotRepository');
        $this->addEntityConfiguration($rootNode, 'Oxygen\PassbookBundle\Entity\BookingSlot', 'Oxygen\PassbookBundle\Entity\Repository\BookingSlotRepository');
        $this->addEntityConfiguration($rootNode, 'Oxygen\PassbookBundle\Entity\BookingPerson', 'Oxygen\PassbookBundle\Entity\Repository\BookingPersonRepository');

        return $treeBuilder;
    }
}
