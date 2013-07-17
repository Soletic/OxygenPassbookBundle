<?php
namespace Oxygen\PassbookBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface implemented to represent event
 * 
 * @author lolozere
 *
 */
interface EventInterface {
	/**
	 * @return integer
	 */
	public function getId();
	/**
	 * Name of the pass. Example : Pass Bien-être 2013
	 * 
	 * @return string
	 */
	public function getName();
	/**
	 * 
	 * @param string $name
	 */
	public function setName($name);
	/**
	 * Date start of the event access
	 * 
	 * @return \DateTime
	 */
	public function getDateStart();
	/**
	 * 
	 * @param \DateTime $dateStart
	 */
	public function setDateStart($dateStart);
	/**
	 * Date end of the event access
	 *
	 * @return \DateTime
	 */
	public function getDateEnd();
	/**
	 * 
	 * @param \DateTime $dateEnd
	 */
	public function setDateEnd($dateEnd);
	/**
	 * Return products in the event
	 * 
	 * @return array
	 */
	public function getProducts();
	/**
	 * Return tickets required for access event
	 * 
	 * @return ArrayCollection
	 */
	public function getTickets();

}