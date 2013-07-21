<?php
namespace Oxygen\PassbookBundle\Form\Handler;

use Oxygen\PassbookBundle\Booking\Exception\BookingsFoundException;

use Symfony\Component\Form\FormError;

use Oxygen\FrameworkBundle\Form\Form;

class EventProductForm extends Form {
	
	protected $eventProduct;
	protected $slots = array();
	protected $event;
	
	public function getData() {
		return $this->eventProduct;
	}
	
	/**
	* @param EventInterface $event
	* @return EventProductForm
	*/
	public function setEvent($event)
	{
	    $this->event = $event;
	    return $this;
	}
	 
	/**
	* @return EventInterface
	*/
	public function getEvent()
	{
	    return $this->event;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\FrameworkBundle\Form\Model.FormModelInterface::load()
	 */
	public function onLoad(array $params) {
		extract($params);
		if (!is_null($id)) {
			$this->eventProduct = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product')->getRepository()->find($id);
			if (is_null($this->eventProduct)) {
				throw (new NotFoundHttpException($this->container->get('translator')->trans('oxygen_passbook.event_product.notfound', array('%id%' => $id))));
			}
			$this->event = $this->eventProduct->getEvent();
		} else {
			$this->eventProduct = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product')->createInstance();
			$this->event = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->getRepository()->find($eventId);
			if (is_null($this->event)) {
				throw (new NotFoundHttpException($this->container->get('translator')->trans('oxygen_passbook.event.notfound', array('%id%' => $eventId))));
			}
			$this->eventProduct->setEvent($this->event);
			$this->event->addProduct($this->eventProduct);
		}
		// Slots
		if (count($this->getData()->getSlots()) <= 0) {
			$entity = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product_slot')->createInstance();
			$this->getData()->addSlot($entity);
		} else {
			$this->slots = $this->getData()->getSlots()->getValues();
		}
		return $this;
	}
	
	public function onSubmit() {
		// Slots relations
		foreach($this->getData()->getSlots() as $slot) {
			if ($slot->getDateStart()->format('Y-m-d H:i') < $this->eventProduct->getEvent()->getDateStart()->format('Y-m-d H:i')
					|| $slot->getDateStart()->format('Y-m-d H:i') > $this->eventProduct->getEvent()->getDateEnd()->format('Y-m-d H:i')) {
				$this->form->get('slots')->addError(new FormError('event_slot.errors.outofbound'));
				return false;
			}
			if (is_null($slot->getId())) {
				$slot->setEventProduct($this->getData());
				$this->container->get('doctrine.orm.entity_manager')->persist($slot);
			}
		}
		foreach($this->getRemovedElement($this->slots, $this->getData()->getSlots()) as $slot) {
			try {
				$this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product_slot')->remove($slot);
			} catch(BookingsFoundException $e) {
				$this->form->addError(new FormError('event_slot.errors.bookings_exist', null, array('%name%' => $slot->__toString())));
				return false;
			}
		}
		
		if (is_null($this->eventProduct->getId())) {
			$this->container->get('doctrine.orm.entity_manager')->persist($this->eventProduct);
		}
		return true;
	}
	
	public function onSuccess() {
		$this->container->get('doctrine.orm.entity_manager')->flush();
		$this->container->get('oxygen_framework.templating.messages')->addSuccess(
				$this->container->get('translator')->trans('oxygen_passbook.event_product.saved', array('%name%' => $this->eventProduct->getName()))
			);
		return true;
	}
	
}