<?php
namespace Oxygen\PassbookBundle\Form\Model;

use Oxygen\PassbookBundle\Model\EventProductInterface;

use Oxygen\PassbookBundle\Model\EventTicketInterface;

use Oxygen\PassbookBundle\Model\EventModel;

use Oxygen\PassbookBundle\Model\EventInterface;

class EventFormModel extends EventModel
{

	/**
	 * @var EventInterface
	 */
	protected $event;
	
	public function __construct() {
		$this->products = array();
		$this->tickets = array();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventModel::addTicket()
	 */
	public function addTicket(EventTicketInterface $ticket) {
		$this->tickets[] = $ticket;
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventModel::removeTicket()
	 */
	public function removeTicket(EventTicketInterface $ticket) {
		foreach($this->tickets as $key => $ticketExist) {
			if ($ticketExist->getId() == $ticket->getId())
				unset($this->tickets[$key]);
		}
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::addProduct()
	 */
	public function addProduct(EventProductInterface $product) {
		throw new \Exception('Not implemented');
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::removeProduct()
	 */
	public function removeProduct(EventProductInterface $product) {
		throw new \Exception('Not implemented');
	}

	/**
	* @param EventInterface $event
	* @return EventFormModel
	*/
	public function setEvent($event)
	{
	    $this->event = $event;
	    $this->setName($this->event->getName());
	    $this->setDateStart($this->event->getDateStart());
	    $this->setDateEnd($this->event->getDateEnd());
	    return $this;
	}
	 
	/**
	* @return EventInterface
	*/
	public function getEvent()
	{
	    return $this->event;
	}

	public function getId()
	{
		return $this->event->getId();
	}

}
