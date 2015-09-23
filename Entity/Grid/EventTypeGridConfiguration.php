<?php
namespace Oxygen\PassbookBundle\Entity\Grid;
use Oxygen\DatagridBundle\Grid\Configuration\Entity\EntityConfiguration;

use Doctrine\ORM\QueryBuilder;

use Oxygen\DatagridBundle\Grid\Configuration\Entity\QueryConfigurationInterface;

use Oxygen\DatagridBundle\Grid\Configuration\SimpleListConfiguration;

class EventTypeGridConfiguration extends EntityConfiguration implements QueryConfigurationInterface
{

	public function manipulateQuery(QueryBuilder $query)
	{

		// Search number of products
		/*$productNumberQuery = $this->getEntitiesServer()->getManager('oxygen_passbook.event_product')->getRepository()->createQueryBuilder('event_product');
		$productNumberQuery->select('TOTAL')*/
		
		//throw new \Exception('manipulateQuery');
	}

}
