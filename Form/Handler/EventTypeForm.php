<?php
namespace Oxygen\PassbookBundle\Form\Handler;

use Symfony\Component\Form\FormError;

use Oxygen\FrameworkBundle\Form\Form;
/**
 * Form to edit EventType
 * 
 * @author lolozere
 *
 */
class EventTypeForm extends Form {
	
	protected $eventType;
	
	public function getData() {
		return $this->eventType;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\FrameworkBundle\Form\Model.FormModelInterface::load()
	 */
	public function onLoad(array $params) {
		extract($params);
		if (!is_null($id)) {
			$this->eventType = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_type')->getRepository()->find($id);
			if (is_null($this->eventType)) {
				throw (new NotFoundHttpException($this->container->get('translator')->trans('oxygen_passbook.event_type.notfound', array('%id%' => $id))));
			}
		} else {
			$this->eventType = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_type')->createInstance();
		}
		return $this;
	}
	
	public function onSubmit() {
		if (is_null($this->eventType->getId()))
			$this->container->get('doctrine.orm.entity_manager')->persist($this->eventType);
		return true;
	}
	
	public function onSuccess() {
		$this->container->get('doctrine.orm.entity_manager')->flush();
		$this->container->get('oxygen_framework.templating.messages')->addSuccess(
				$this->container->get('translator')->trans('oxygen_passbook.event_type.saved', array('%name%' => $this->eventType->getName()))
			);
		return true;
	}
	
}