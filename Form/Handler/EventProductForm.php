<?php
namespace Oxygen\PassbookBundle\Form\Handler;

use Oxygen\FrameworkBundle\Form\Form;

class EventProductForm extends Form {
	
	protected $eventProduct;
	protected $event;
	
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
		}
		$this->getModel()->setEventProduct($this->eventProduct);
		return $this;
	}
	
	public function onSubmit() {
		$this->eventProduct->setName($this->getModel()->getName());
		$this->eventProduct->setUrl($this->getModel()->getUrl());
		$this->eventProduct->setDescription($this->getModel()->getDescription());
		$this->eventProduct->setEvent($this->event);
		if (is_null($this->eventProduct->getId())) {
			$this->event->addProduct($this->eventProduct);
			$this->get('doctrine.orm.entity_manager')->persist($this->eventProduct);
		}
		return true;
	}
	
	public function onSuccess() {
		$this->container->get('doctrine.orm.entity_manager')->flush();
		$this->container->get('oxygen_framework.templating.messages')->addSuccess(
				$this->container->get('translator')->trans('oxygen_passbook.event_product.saved', array('%name%' => $this->event->getName()))
			);
		return true;
	}
	
}