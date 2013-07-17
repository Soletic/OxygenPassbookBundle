<?php
namespace Oxygen\PassbookBundle\Form\Model;

use Oxygen\PassbookBundle\Model\EventTicketModel;

class EventTicketFormModel extends EventTicketModel
{

	/**
	 * @var EventTicketInterface
	 */
	protected $eventTicket;
	
	/**
	* @param EventTicketInterface $eventTicket
	* @return EventTicketFormModel
	*/
	public function setEventTicket($eventTicket)
	{
	    $this->eventTicket = $eventTicket;
	    $this->setName($eventTicket->getName());
	    $this->setLimitAnimations($eventTicket->getLimitAnimations());
	    return $this;
	}
	 
	/**
	* @return EventTicketInterface
	*/
	public function getEventTicket()
	{
	    return $this->eventTicket;
	}

	public function getId()
	{
		return $this->eventTicket->getId();
	}

}
