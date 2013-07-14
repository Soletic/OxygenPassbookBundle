<?php
namespace Oxygen\PassbookBundle\Form\Model;
use Oxygen\PassbookBundle\Model\EventModel;

use Oxygen\PassbookBundle\Model\EventInterface;

class EventFormModel extends EventModel
{

	/**
	 * @var EventInterface
	 */
	protected $event;

	public function __construct(EventInterface $event)
	{
		$this->event = $event;
		$this->setName($event->getName());
		$this->setDateStart($event->getDateStart());
		$this->setDateEnd($event->getDateEnd());
	}

	public function getId()
	{
		return $this->event->getId();
	}

}
