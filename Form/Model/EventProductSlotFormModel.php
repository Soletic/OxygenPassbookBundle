<?php
namespace Oxygen\PassbookBundle\Form\Model;

use Oxygen\PassbookBundle\Model\EventProductSlotModel;

use Oxygen\FrameworkBundle\Form\Model\EntityEmbeddedInterface;

class EventProductSlotFormModel extends EventProductSlotModel implements EntityEmbeddedInterface
{

	/**
	 * @var EventProductSlotModel
	 */
	protected $entity;
	
	/**
	* @param EventProductSlotModel $eventTicket
	* @return EventTicketFormModel
	*/
	public function setEntity($entity)
	{
	    $this->entity = $entity;
	    return $this;
	}
	 
	/**
	* @return EventProductSlotModel
	*/
	public function getEntity()
	{
	    return $this->entity;
	}

	public function getId()
	{
		return $this->eventTicket->getId();
	}

}
