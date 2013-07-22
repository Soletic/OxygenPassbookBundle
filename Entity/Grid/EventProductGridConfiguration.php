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
		
		// Bookings total
		$total = $this->getEntitiesServer()->getManager('oxygen_passbook.booking_slot')->getRepository()->createQueryBuilder('booking_slot')
			->select('COUNT(booking_slot.id)')
			->innerJoin('booking_slot.eventProductSlot', 'event_product_slot')->innerJoin('event_product_slot.eventProduct', 'event_product')
			->where('event_product.id='.$query->getRootAlias().'.id');
		
		$query->addSelect('('.$total->getDQL().') as bookingsTotal');
		
		// get event id
		$query->innerJoin($query->getRootAlias().'.event', 'product_event')->andWhere('product_event.id=:eventId')->setParameter('eventId', $this->getParameter('eventId'));
	}

}
