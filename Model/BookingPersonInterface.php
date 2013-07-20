<?php
namespace Oxygen\PassbookBundle\Model;

/**
 * Interface for person booking
 * 
 * @author lolozere
 *
 */
interface BookingPersonInterface {
	
	public function getId();
	
	/**
	* Name of the person
	* 
	* @param string $name
	* @return BookingPersonInterface
	*/
	public function setName($name);
	 
	/**
	* Return name of the person
	* 
	* @return string
	*/
	public function getName();
	
	/**
	* @param string $email
	* @return BookingPersonInterface
	*/
	public function setEmail($email);
	 
	/**
	* @return string
	*/
	public function getEmail();
	/**
	* Add booking for a slot
	* 
	* @param BookingSlotInterface $bookingSlot
	* @return BookingPersonInterface
	*/
	public function addBookingSlot(BookingSlotInterface $bookingSlot);
	/**
	 * Remove booking for a slot
	 * 
	 * @param BookingSlotInterface $bookingSlot
	 * @return BookingPersonInterface
	 */
	public function removeBookingSlot(BookingSlotInterface $bookingSlot);
	/**
	* @return array
	*/
	public function getBookingSlots();
}