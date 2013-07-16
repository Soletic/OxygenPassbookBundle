<?php
namespace Oxygen\PassbookBundle\Form\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Oxygen\PassbookBundle\Model\EventModel;

use Oxygen\PassbookBundle\Model\EventInterface;

class EventFormModel extends EventModel
{

	/**
	 * @var EventInterface
	 */
	protected $event;

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
