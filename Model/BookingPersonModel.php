<?php
namespace Oxygen\PassbookBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Person booking slot
 * 
 * @author lolozere
 *
 */
abstract class BookingPersonModel implements BookingPersonInterface {
	
	protected $id;
	protected $name;
	protected $email;
	protected $bookingSlots;
	
	public function __construct() {
		$this->bookingSlots = new ArrayCollection();
	}
	
	public function getId() {
		return $this->id;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingPersonInterface::setName()
	 */
	public function setName($name)
	{
	    $this->name = $name;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingPersonInterface::getName()
	 */
	public function getName()
	{
	    return $this->name;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingPersonInterface::setEmail()
	 */
	public function setEmail($email)
	{
	    $this->email = $email;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingPersonInterface::getEmail()
	 */
	public function getEmail()
	{
	    return $this->email;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingPersonInterface::addBookingSlot()
	 */
	public function addBookingSlot(BookingSlotInterface $bookingSlot)
	{
	    $this->bookingSlots->add($bookingSlot);
	    return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingPersonInterface::removeBookingSlot()
	 */
	public function removeBookingSlot(BookingSlotInterface $bookingSlot)
	{
	    $this->bookingSlots->removeElement($bookingSlot);
	    return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.BookingPersonInterface::getBookingSlots()
	 */
	public function getBookingSlots()
	{
	    return $this->bookingSlots;
	}
	
}