<?php
namespace Oxygen\PassbookBundle\Entity;
use Oxygen\PassbookBundle\Model\EventProductInterface;

use Oxygen\PassbookBundle\Model\EventTicketInterface;

use Oxygen\PassbookBundle\Model\EventModel;

/**
 * Pass Entity
 * 
 * @author lolozere
 *
 */
class Event extends EventModel
{
	
	public function __construct() {
		$this->products = new ArrayCollection();
		$this->tickets = new ArrayCollection();
	}
	
	/**
	 * Add ticket access
	 *
	 * @param EventTicketInterface $ticket
	 * @return EventModel
	 */
	public function addTicket(EventTicketInterface $ticket) {
		$this->tickets->add($ticket);
		return $this;
	}
	/**
	 * Remove ticket access
	 *
	 * @param EventTicketInterface $ticket
	 * @return EventModel
	 */
	public function removeTicket(EventTicketInterface $ticket) {
		$this->tickets->removeElement($ticket);
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::addProduct()
	 */
	public function addProduct(EventProductInterface $product) {
		$this->products->add($product);
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::removeProduct()
	 */
	public function removeProduct(EventProductInterface $product) {
		$this->products->removeElement($product);
		return $this;
	}
}
