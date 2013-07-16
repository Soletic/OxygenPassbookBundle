<?php
namespace Oxygen\PassbookBundle\Form\Handler;

use Oxygen\FrameworkBundle\Form\Form;

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
				throw (new NotFoundHttpException($container->get('translator')->trans('oxygen_passbook.event.notfound', array('%id%' => $id))));
			}
		} else {
			$this->event = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->createInstance();
		}
		$this->getModel()->setEvent($this->event);
		return $this;
	}
	
	public function onSubmit() {
		$this->event->setName($this->getModel()->getName());
		$this->event->setDateStart($this->getModel()->getDateStart());
		$this->event->setDateEnd($this->getModel()->getDateEnd());
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