<?php
namespace Oxygen\PassbookBundle\Model;

/**
 * Ticket require to access event
 *
 * @author lolozere
 *
 */
abstract class EventTicketModel implements EventTicketInterface {
	
	protected $id;
	protected $event;
	protected $name;
	protected $limitAnimations = 1;
	
	public function getId() {
		return $this->id;
	}
	
	/**
	* @param EventInterface $event
	* @return EventTicket
	*/
	public function setEvent($event)
	{
	    $this->event = $event;
	    return $this;
	}
	 
	/**
	* @return EventInterface
	*/
	public function getEvent()
	{
	    return $this->event;
	}
	
	/**
	* @param integer $limitAnimations
	* @return EventTicket
	*/
	public function setLimitAnimations($limitAnimations)
	{
	    $this->limitAnimations = $limitAnimations;
	    return $this;
	}
	 
	/**
	* @return integer
	*/
	public function getLimitAnimations()
	{
	    return $this->limitAnimations;
	}
	
	/**
	* @param string $name
	* @return EventTicketModel
	*/
	public function setName($name)
	{
	    $this->name = $name;
	    return $this;
	}
	 
	/**
	* @return string
	*/
	public function getName()
	{
	    return $this->name;
	}

	public function __toString() {
		return $this->getName();
	}
}