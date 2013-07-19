<?php
namespace Oxygen\PassbookBundle\Form\Model;

use Oxygen\FrameworkBundle\Form\Model\EntityEmbeddedInterface;

use Oxygen\PassbookBundle\Model\EventProductInterface;

use Oxygen\PassbookBundle\Model\EventTicketInterface;

use Oxygen\PassbookBundle\Model\EventModel;

use Oxygen\PassbookBundle\Model\EventInterface;

class EventFormModel extends EventModel implements EntityEmbeddedInterface
{

	/**
	 * @var EventInterface
	 */
	protected $event;
	
	/**
	* @param EventInterface $event
	* @return EventFormModel
	*/
	public function setEntity($entity)
	{
	    $this->event = $entity;
	    return $this;
	}
	 
	/**
	* @return EventInterface
	*/
	public function getEntity()
	{
	    return $this->event;
	}
	

	public function getId()
	{
		return $this->event->getId();
	}

}
