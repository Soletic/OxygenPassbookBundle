<?php
namespace Oxygen\PassbookBundle\Model;

/**
 * A product proposed in an event
 * 
 * @author lolozere
 *
 */
abstract class EventProductModel implements EventProductInterface {
	
	protected $id;
	protected $name;
	protected $description;
	protected $url;
	protected $event;
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductInterface::getId()
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductInterface::getName()
	 */
	public function getName() {
		return $this->name; 
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductInterface::setName()
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductInterface::getDescription()
	 */
	public function getDescription() {
		return $this->description;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductInterface::setDescription()
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductInterface::getUrl()
	 */
	public function getUrl() {
		return $this->url;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductInterface::setUrl()
	 */
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductInterface::setEvent()
	 */
	public function setEvent($event)
	{
	    $this->event = $event;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductInterface::getEvent()
	 */
	public function getEvent()
	{
	    return $this->event;
	}
	
}