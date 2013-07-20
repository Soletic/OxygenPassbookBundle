<?php
namespace Oxygen\PassbookBundle\Entity\Grid;

use Oxygen\DatagridBundle\Grid\Configuration\Entity\EntityConfiguration;

use Doctrine\ORM\QueryBuilder;

use Oxygen\DatagridBundle\Grid\Configuration\Entity\QueryConfigurationInterface;

class EventBookingGridConfiguration extends EntityConfiguration implements QueryConfigurationInterface
{

	public function manipulateQuery(QueryBuilder $query)
	{
		$root = $query->getRootAlias();
		/*
		 * Add number of reservations
		 */
		$bookingSlotQueryBuilder = $this->getEntitiesServer()->getManager('oxygen_passbook.booking_slot')->getRepository()->createQueryBuilder('booking_slot');
		$bookingPersonQueryBuilder = $this->getEntitiesServer()->getManager('oxygen_passbook.booking_person')->getRepository()->createQueryBuilder('booking_person');
		// Slot bookings
		$bookingSlotQueryBuilder->select('booking_slot.id')
			->innerJoin('booking_slot.bookingPerson', 'booking_person_sub')
			->innerJoin('booking_slot.eventProductSlot', 'booking_slot_product')
			->innerJoin('booking_slot_product.eventProduct', 'event_product')
			->innerJoin('event_product.event', 'event_countable')
			->where('event_countable.id='.$root.'.id')
			->andWhere('booking_person_sub.id='.$bookingPersonQueryBuilder->getRootAlias().'.id');
		// Person bookings
		$bookingPersonQueryBuilder->select('COUNT(booking_person.id) as totalPerson')
			->where($bookingPersonQueryBuilder->expr()->exists(
					$bookingSlotQueryBuilder
				));
		
		$query->addSelect('('.$bookingPersonQueryBuilder->getDQL().') as bookings');
		
		// Limit to current event
		$query->andWhere($root.'.dateEnd>:limitdate')->setParameter('limitdate', new \DateTime());
	}

}
