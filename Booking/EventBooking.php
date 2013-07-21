<?php
namespace Oxygen\PassbookBundle\Booking;

use Oxygen\PassbookBundle\Model\BookingPersonInterface;
use Oxygen\FrameworkBundle\Model\EntitiesServer;

/**
 * Service to manage booking
 * 
 * @author lolozere
 *
 */
class EventBooking {
	
	/**
	 * @var EntitiesServer
	 */
	protected $entitiesServer;
	
	public function __construct($entitiesServer) {
		$this->entitiesServer = $entitiesServer;
	}
	/**
	 * Remove bookings for an event and a person
	 * 
	 * @var BookingPersonInterface $bookingPerson
	 * @param integer $eventId
	 */
	public function removeBookings(BookingPersonInterface $bookingPerson, $eventId) {
		foreach($bookingPerson->getBookingSlots() as $bookingSlot) {
			if ($bookingSlot->getEventProductSlot()->getEventProduct()->getEvent()->getId() == $eventId) {
				$bookingPerson->removeBookingSlot($bookingSlot);
				$this->entitiesServer->getEntityManager()->remove($bookingSlot);
			}
		}
	}
	
}