<?php
namespace Oxygen\PassbookBundle\Entity\Grid;
use Oxygen\DatagridBundle\Grid\Configuration\Entity\EntityConfiguration;

use Doctrine\ORM\QueryBuilder;

use Oxygen\DatagridBundle\Grid\Configuration\Entity\QueryConfigurationInterface;

use Oxygen\DatagridBundle\Grid\Configuration\SimpleListConfiguration;

class EventProductGridConfiguration extends EntityConfiguration implements QueryConfigurationInterface
{

	public function manipulateQuery(QueryBuilder $query)
	{
		$this->validateRequired(array('eventId'));
		$query->innerJoin($query->getRootAlias().'.event', 'product_event')->andWhere('product_event.id=:eventId')->setParameter('eventId', $this->getParameter('eventId'));
	}

}
