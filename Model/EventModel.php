<?php
namespace Oxygen\PassbookBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model representing event access pass 
 * 
 * @author lolozere
 *
 */
abstract class EventModel implements EventInterface {
	
	protected $id;
	protected $name;
	protected $dateStart;
	protected $dateEnd;
	protected $products;
	protected $tickets;
	protected $type;
	
	public function __construct() {
		$this->products = new ArrayCollection();
		$this->tickets = new ArrayCollection();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::getId()
	 */
	public function getId() { return $this->id; }
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::getType()
	 */
	public function getType() {
		return $this->type;
	}
	
	public function setType($type) {
		$this->type = $type;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::setName()
	 */
	public function setName($name)
	{
	    $this->name = $name;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::getName()
	 */
	public function getName()
	{
	    return $this->name;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::setDateStart()
	 */
	public function setDateStart($dateStart)
	{
	    $this->dateStart = $dateStart;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::getDateStart()
	 */
	public function getDateStart()
	{
	    return $this->dateStart;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::setDateEnd()
	 */
	public function setDateEnd($dateEnd)
	{
	    $this->dateEnd = $dateEnd;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::getDateEnd()
	 */
	public function getDateEnd()
	{
	    return $this->dateEnd;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::getProducts()
	 */
	public function getProducts() {
		return $this->products;
	}
	
	public function getTickets() {
		return $this->tickets;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::addTicket()
	 */
	public function addTicket(EventTicketInterface $ticket) {
		$this->tickets->add($ticket);
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventInterface::removeTicket()
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