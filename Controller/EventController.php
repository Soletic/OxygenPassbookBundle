<?php
namespace Oxygen\PassbookBundle\Controller;
use Oxygen\PassbookBundle\Booking\Exception\BookingsFoundException;

use Oxygen\PassbookBundle\Form\Model\EventProductFormModel;

use Oxygen\PassbookBundle\Form\Model\EventFormModel;

use Oxygen\FrameworkBundle\Controller\OxygenController;

/**
 * Controller with actions to manage Event
 * 
 * @author lolozere
 *
 */
class EventController extends OxygenController
{

	public function listEventsAction()
	{
		$grid_view = $this->get('oxygen_datagrid.loader')->getView('oxygen_passbook_event');
		return $grid_view->getGridResponse('OxygenPassbookBundle:Event:list.html.twig');
	}

	public function listEventProductsAction($eventId)
	{
		$event = $this->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->getRepository()->find($eventId);
		if (is_null($event)) {
			throw $this->createNotFoundException($this->get('translator')->trans('oxygen_passbook.event.notfound', array('%id%' => $id)));
		}
		$grid_view = $this->get('oxygen_datagrid.loader')->getView(
				'oxygen_passbook_event_product', array('eventId' => $eventId)
			);
		return $grid_view->getGridResponse('OxygenPassbookBundle:Event:list_event_product.html.twig', array('event' => $event));
	}

	public function deleteEventAction($id)
	{
		$event = $this->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->getRepository()->find($id);
		if (is_null($event)) {
			throw $this->createNotFoundException($this->get('translator')->trans('oxygen_passbook.event.notfound', array('%id%' => $id)));
		}
		try {
			$this->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->remove($event);
			$this->getDoctrine()->getEntityManager()->flush();
			$this->get('oxygen_framework.templating.messages')->addSuccess($this->translate('oxygen_passbook.event.deleted', array('%name%' => $event->getName())));
		} catch(BookingsFoundException $e) {
			$this->get('oxygen_framework.templating.messages')->addError($this->translate('oxygen_passbook.event.bookings_exist', array('%name%' => $event->getName())));
		}
		return $this->redirect($this->generateUrl('oxygen_passbook_event_list'));
	}
	
	public function deleteEventProductAction($id)
	{
		$eventProduct = $this->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product')->getRepository()->find($id);
		if (is_null($eventProduct)) {
			throw $this->createNotFoundException($this->get('translator')->trans('oxygen_passbook.event_product.notfound', array('%id%' => $id)));
		}
		$eventId = $eventProduct->getEvent()->getId();
		try {
			$this->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product')->remove($eventProduct);
			$this->getDoctrine()->getEntityManager()->flush();
			$this->get('oxygen_framework.templating.messages')->addSuccess($this->translate('oxygen_passbook.event_product.deleted', array('%name%' => $eventProduct->getName())));
		} catch(BookingsFoundException $e) {
			$this->get('oxygen_framework.templating.messages')->addError($this->translate('oxygen_passbook.event_product.bookings_exist', array('%name%' => $eventProduct->getName())));
		}
		return $this->redirect($this->generateUrl('oxygen_passbook_event_product_list', array('eventId' => $eventId)));
	}

	public function editEventAction($id = null)
	{
		$form = $this->get('oxygen_framework.form')->getForm('oxygen_passbook_event_form', array('id' => $id));
		if ($form->isSubmitted()) {
			if ($form->process()) {
				return $this->redirect($this->generateUrl('oxygen_passbook_event_list'));
			}
		}
		return $this->render('OxygenPassbookBundle:Event:edit.html.twig', array('form' => $form->createView()));
	}

	public function editEventProductAction($eventId = null, $id = null, $copy = false)
	{
		if ($copy && !is_null($id)) {
			$eventProduct = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product')->getRepository()->find($id);
			if (is_null($eventProduct)) {
				throw $this->createNotFoundException($this->container->get('translator')->trans('oxygen_passbook.event_product.notfound', array('%id%' => $id)));
			}
			$newEventProduct = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product')->createInstance();
			$newEventProduct->setName($eventProduct->getName() . ' Copie');
			$newEventProduct->setDescription($eventProduct->getDescription());
			$newEventProduct->setUrl($eventProduct->getUrl());
			foreach($eventProduct->getSlots() as $slot) {
				$newSlot = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product_slot')->createInstance();
				$newSlot->setDateStart($slot->getDateStart());
				$newSlot->setDateEnd($slot->getDateEnd());
				$newSlot->setSeatMax($slot->getSeatMax());
				$newSlot->setEventProduct($newEventProduct);
				$newEventProduct->addSlot($newSlot);
			}
			$newEventProduct->setEvent($eventProduct->getEvent());
			$eventProduct->getEvent()->addProduct($newEventProduct);
			$this->getDoctrine()->getEntityManager()->persist($newEventProduct);
			$this->getDoctrine()->getEntityManager()->flush();
			$this->container->get('oxygen_framework.templating.messages')->addSuccess(
					$this->container->get('translator')->trans('oxygen_passbook.event_product.copied', array('%name%' => $eventProduct->getName()))
			);
			return $this->redirect($this->generateUrl('oxygen_passbook_event_product_edit', array('eventId' => $newEventProduct->getEvent()->getId(), 'id' => $newEventProduct->getId())));
		}
		$form = $this->get('oxygen_framework.form')->getForm('oxygen_passbook_event_product_form', array(
				'id' => $id, 'eventId' => $eventId, 'copy' => $copy
			));
		if ($form->isSubmitted()) {
			if ($form->process()) {
				return $this->redirect($this->generateUrl('oxygen_passbook_event_product_list', array('eventId' => $form->getEvent()->getId())));
			}
		}
		return $this->render('OxygenPassbookBundle:Event:edit_product.html.twig', array('form' => $form->createView(), 'event' => $form->getEvent()));
	}

	public function publishEventAction($eventId, $state) {
		$event = $this->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->getRepository()->find($eventId);
		if (is_null($event)) {
			throw $this->createNotFoundException($this->get('translator')->trans('oxygen_passbook.event.notfound', array('%id%' => $id)));
		}
		
		$event->setOpened($state);
		$this->getDoctrine()->getEntityManager()->flush();
		$this->get('oxygen_framework.templating.messages')->addSuccess($this->translate('oxygen_passbook.event.'.(($state)?'published':'unpublished'), array('%name%' => $event->getName())));
		
		return $this->redirect($this->generateUrl('oxygen_passbook_event_list'));
	}
	
}
