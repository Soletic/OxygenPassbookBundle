<?php
namespace Oxygen\PassbookBundle\Form\Handler;

use Symfony\Component\Form\FormError;

use Oxygen\FrameworkBundle\Form\Form;
/**
 * Form to edit Event
 * 
 * @author lolozere
 *
 */
class EventForm extends Form {
	
	protected $event;
	
	public function getData() {
		return $this->event;
	}
	
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
		// Tickets init with one
		if (count($this->getData()->getTickets()) <= 0) {
			$entity = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_ticket')->createInstance();
			$this->getData()->addTicket($entity);
		}
		return $this;
	}
	
	public function onSubmit() {
		if ($this->getData()->getDateStart()->format('Y-m-d H:i') > $this->getData()->getDateEnd()->format('Y-m-d H:i')) {
			$this->form->addError(new FormError('event.errors.date'));
			return false;
		}
		// Tickets relations
		foreach($this->getData()->getTickets() as $ticket) {
			if (is_null($ticket->getId())) {
				$ticket->setEvent($this->getData());
				$this->container->get('doctrine.orm.entity_manager')->persist($ticket);
			}
		}
		
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