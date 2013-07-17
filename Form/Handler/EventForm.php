<?php
namespace Oxygen\PassbookBundle\Form\Handler;

use Oxygen\FrameworkBundle\Form\Form;
/**
 * Form to edit Event
 * 
 * @author lolozere
 *
 */
class EventForm extends Form {
	
	protected $event;
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\FrameworkBundle\Form\Model.FormModelInterface::load()
	 */
	public function onLoad(array $params) {
		extract($params);
		if (!is_null($id)) {
			$this->event = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->getRepository()->find($id);
			if (is_null($this->event)) {
				throw (new NotFoundHttpException($this->container->get('translator')->trans('oxygen_passbook.event.notfound', array('%id%' => $id))));
			}
		} else {
			$this->event = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->createInstance();
		}
		$this->getModel()->setEvent($this->event);
		
		// Tickets
		if (count($this->event->getTickets()) <= 0) {
			$entity = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_ticket')->createInstance();
			$this->event->addTicket($entity);
		}
		$ticketClass = $this->container->getParameter('oxygen_passbook.event_ticket.form.model_class');
		foreach($this->event->getTickets() as $entity) {
			$ticket = new $ticketClass();
			$ticket->setEventTicket($entity);
			$this->getModel()->addTicket($ticket);
		}
		
		return $this;
	}
	
	public function onSubmit() {
		$this->event->setName($this->getModel()->getName());
		$this->event->setDateStart($this->getModel()->getDateStart());
		$this->event->setDateEnd($this->getModel()->getDateEnd());
		
		// Tickets
		foreach($this->getModel()->getTickets() as $ticket) {
			$ticket->getEventTicket()->setName($ticket->getName());
			$ticket->getEventTicket()->setLimitAnimations($ticket->getLimitAnimations());
			if (is_null($ticket->getEventTicket()->getId())) {
				$ticket->getEventTicket()->setEvent($this->event);
				$this->container->get('doctrine.orm.entity_manager')->persist($ticket->getEventTicket());
			}
		}
		$this->updateCollection($this->getModel()->getTickets(), $this->event->getTickets());
		
		if (is_null($this->event->getId()))
			$this->container->get('doctrine.orm.entity_manager')->persist($this->event);
		return true;
	}
	
	public function onSuccess() {
		$this->container->get('doctrine.orm.entity_manager')->flush();
		$this->container->get('oxygen_framework.templating.messages')->addSuccess(
				$this->container->get('translator')->trans('oxygen_passbook.event.saved', array('%name%' => $this->event->getName()))
			);
		return true;
	}
	
}