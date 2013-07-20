<?php
namespace Oxygen\PassbookBundle\Model;

/**
 * Booking of a person for a slot
 * 
 * @author lolozere
 *
 */
abstract class BookingSlotModel implements BookingSlotInterface {
	
	protected $id;
	/**
	 * @var \DateTime
	 */
	protected $createdAt;
	/**
	 * @var EventProductSlotInterface
	 */
	protected $eventProductSlot;
	/**
	 * @var BookingPersonInterface
	 */
	protected $bookingPerson;
	
	public function getId() {
		return $this->id;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingSlotInterface::setCreatedAt()
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingSlotInterface::getCreatedAt()
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingSlotInterface::setBookingPerson()
	 */
	public function setBookingPerson($bookingPerson) {
		$this->bookingPerson = $bookingPerson;
		return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingSlotInterface::getBookingPerson()
	 */
	public function getBookingPerson() {
		return $this->bookingPerson;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingSlotInterface::setEventProductSlot()
	 */
	public function setEventProductSlot($eventProductSlot) {
		$this->eventProductSlot = $eventProductSlot;
		return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingSlotInterface::getEventProductSlot()
	 */
	public function getEventProductSlot() {
		return $this->eventProductSlot;
	}
}