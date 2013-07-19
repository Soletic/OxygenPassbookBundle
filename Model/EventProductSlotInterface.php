<?php
namespace Oxygen\PassbookBundle\Model;

/**
 * Interface for slot of an event animation
 * 
 * @author lolozere
 *
 */
interface EventProductSlotInterface {
	/**
	 * Event product
	 * 
	 * @return EventProduct
	 */
	public function getEventProduct();
	public function setEventProduct(EventProductInterface $eventProduct);
	/**
	 * @return integer
	 */
	public function getId();
	/**
	 * Return date start of slot
	 * 
	 * @return \DateTime
	 */
	public function getDateStart();
	public function setDateStart($dateStart);
	/**
	 * Return date end of slot
	 * 
	 * @return \DateTime
	 */
	public function getDateEnd();
	public function setDateEnd($dateEnd);
	/**
	 * Return max seat of animation
	 * 
	 * @return integer
	 */
	public function getSeatMax();
	public function setSeatMax($seatMax);
	
}