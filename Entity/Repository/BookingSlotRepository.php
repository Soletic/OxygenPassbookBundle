<?php
namespace Oxygen\PassbookBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * 
 * 
 * @author lolozere
 *
 */
class BookingSlotRepository extends EntityRepository
{
	/**
	 * Return number seats booking for a slot
	 * 
	 * @param integer $eventProductSlotId
	 */
	public function getTotalSeat($eventProductSlotId, $exludeBookingPersonId = null) {
		$query = $this->createQueryBuilder('booking_slot')->select('COUNT(booking_slot.id)')
			->innerJoin('booking_slot.eventProductSlot', 'slot')
			->where('slot.id=:id')->setParameter('id', $eventProductSlotId);
		if (!is_null($exludeBookingPersonId)) {
			$query->innerJoin('booking_slot.bookingPerson', 'booking_person')->andWhere('booking_person<>:personId')->setParameter('personId', $exludeBookingPersonId);
		}
		return $query->getQuery()->getSingleScalarResult();
	}
	/**
	 * Return bookings slot for an event product
	 * 
	 * @param integer $eventProductId
	 */
	public function findByEventProduct($eventProductId) {
		return $this->createQueryBuilder('booking_slot')->innerJoin('booking_slot.eventProductSlot', 'slot')
			->innerJoin('slot.eventProduct', 'event_product')->where('event_product.id=:id')
			->setParameter('id', $eventProductId)->getQuery()->getResult();
	}
	/**
	 * Return bookings slot for an event
	 *
	 * @param integer $eventId
	 */
	public function findByEvent($eventId) {
		return $this->createQueryBuilder('booking_slot')->innerJoin('booking_slot.eventProductSlot', 'slot')
			->innerJoin('slot.eventProduct', 'event_product')
			->innerJoin('event_product.event', 'event')->where('event.id=:id')
			->setParameter('id', $eventId)->getQuery()->getResult();
	}
	
}