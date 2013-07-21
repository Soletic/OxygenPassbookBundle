<?php
namespace Oxygen\PassbookBundle\Form\Model;

/**
 * Form to book slots on an event
 * 
 * @author lolozere
 *
 */
class BookingFormModel {
	
	protected $person;
	protected $eventTicket;
	protected $bookingSlots = array();
	
	public function __get($key) {
		$parts = explode('_', $key);
		if (count($parts) == 2) {
			return $this->bookingSlots[$parts[1]];
		}
		throw new \Exception($key . " doesn't exist");
	}
	
	public function __set($key, $value) {
		$parts = explode('_', $key);
		if (count($parts) == 2) {
			$this->bookingSlots[$parts[1]] = $value;
		}
	}
	
	public function __construct() {
		$this->bookingSlots = array();
	}
	
	/**
	* @param BookingPersonInterface $person
	* @return BookingFormModel
	*/
	public function setPerson($person)
	{
	    $this->person = $person;
	    return $this;
	}
	 
	/**
	* @return BookingPersonInterface
	*/
	public function getPerson()
	{
	    return $this->person;
	}
	
	public function getBookingSlots() {
		return $this->bookingSlots;
	}
	
	/**
	 * @return array
	 */
	public function setBookingSlot($index, $value)
	{
		$this->bookingSlots[$index] = $value;
		return $this;
	}
	
	/**
	* @return array
	*/
	public function getBookingSlot($index)
	{
	    return $this->bookingSlots[$index];
	}
	
	/**
	* @param EventTicketInterface $eventTicket
	* @return BookingFormModel
	*/
	public function setEventTicket($eventTicket)
	{
	    $this->eventTicket = $eventTicket;
	    return $this;
	}
	 
	/**
	* @return EventTicketInterface
	*/
	public function getEventTicket()
	{
	    return $this->eventTicket;
	}
}