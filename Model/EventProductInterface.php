<?php
namespace Oxygen\PassbookBundle\Model;

/**
 * Interface implemented to represent a product event
 * 
 * @author lolozere
 *
 */
interface EventProductInterface {
	/**
	 * @return integer
	 */
	public function getId();
	/**
	 * Name of the product event
	 * 
	 * @return string
	 */
	public function getName();
	/**
	 * 
	 * @param string $name
	 * @return EventInterface
	 */
	public function setName($name);
	/**
	 * Set description
	 * 
	 * @return string
	 */
	public function getDescription();
	/**
	 * 
	 * @param \string $description
	 * @return EventInterface
	 */
	public function setDescription($description);
	/**
	 * Set url presenting the product
	 *
	 * @return string
	 */
	public function getUrl();
	/**
	 * 
	 * @param \DateTime $dateEnd
	 * @return EventInterface
	 */
	public function setUrl($dateEnd);
	
	/**
	* Set event base of the product 
	* 
	* @param EventInterface $event
	* @return EventInterface
	*/
	public function setEvent($event);
	 
	/**
	* @return EventInterface
	*/
	public function getEvent();
	
}