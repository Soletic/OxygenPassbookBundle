<?php
namespace Oxygen\PassbookBundle\Controller;
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
		$grid_view = $this->get('oxygen_datagrid.loader')->getView('oxygen_passbook_event_product');
		return $grid_view->getGridResponse('OxygenPassbookBundle:Event:list_event_product.html.twig', array('event' => $event));
	}

	public function deleteEventAction($id)
	{
		$event = $this->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->getRepository()->find($id);
		if (is_null($event)) {
			throw $this->createNotFoundException($this->get('translator')->trans('oxygen_passbook.event.notfound', array('%id%' => $id)));
		}
		$this->getDoctrine()->getEntityManager()->remove($event);
		$this->getDoctrine()->getEntityManager()->flush();
		$this->get('oxygen_framework.templating.messages')->addSuccess($this->translate('oxygen_passbook.event.deleted', array('%name%' => $event->getName())));
		return $this->redirect($this->generateUrl('oxygen_passbook_event_list'));
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
		$form = $this->get('oxygen_framework.form')->getForm('oxygen_passbook_event_product_form', array(
				'id' => $id, 'eventId' => $eventId, 'copy' => $copy
			));
		if ($form->isSubmitted()) {
			if ($form->process()) {
				return $this->redirect($this->generateUrl('oxygen_passbook_event_product_list', array('eventId' => $eventId)));
			}
		}
		return $this->render('OxygenPassbookBundle:Event:edit_product.html.twig', array('form' => $form->createView(), 'event' => $form->getEvent()));
	}

}
