<?php
namespace Oxygen\PassbookBundle\Model;

/**
 * Booking of a person for a slot
 * 
 * @author lolozere
 *
 */
interface BookingSlotInterface {
	
	public function getId();
	
	/**
	* @param \DateTime $createdAt
	* @return BookingSlotInterface
	*/
	public function setCreatedAt($createdAt);
	 
	/**
	* @return \DateTime
	*/
	public function getCreatedAt();
	
	/**
	* @param BookingPersonInterface $bookingPerson
	* @return BookingSlotInterface
	*/
	public function setBookingPerson($bookingPerson);
	 
	/**
	* @return BookingPersonInterface
	*/
	public function getBookingPerson();
	
	/**
	* @param EventProductSlotInterface $eventProductSlot
	* @return BookingSlotInterface
	*/
	public function setEventProductSlot($eventProductSlot);
	 
	/**
	* @return EventProductSlotInterface
	*/
	public function getEventProductSlot();

	/**
	* @param EventTicketInterface $eventTicket
	* @return BookingSlotInterface
	*/
	public function setEventTicket($eventTicket);
	 
	/**
	* @return EventTicketInterface
	*/
	public function getEventTicket();

}