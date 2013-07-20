<?php
namespace Oxygen\PassbookBundle\Entity\Grid;
use Oxygen\DatagridBundle\Grid\Configuration\Entity\EntityConfiguration;

use Doctrine\ORM\QueryBuilder;

use Oxygen\DatagridBundle\Grid\Configuration\Entity\QueryConfigurationInterface;

use Oxygen\DatagridBundle\Grid\Configuration\SimpleListConfiguration;

class BookingPersonGridConfiguration extends EntityConfiguration implements QueryConfigurationInterface
{

	public function manipulateQuery(QueryBuilder $query)
	{
		$this->validateRequired(array('eventId'));
		
		$query->innerJoin($query->getRootAlias().'.bookingSlots', 'booking_slot')
			->innerJoin('booking_slot.eventProductSlot', 'product_slot')
			->innerJoin('product_slot.eventProduct', 'event_product')
			->innerJoin('event_product.event', 'event')
			->andWhere('event.id=:eventId')->setParameter('eventId', $this->getParameter('eventId'));
	}

}
