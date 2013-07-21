<?php
namespace Oxygen\PassbookBundle\Controller;
use Oxygen\PassbookBundle\Form\Model\EventProductFormModel;

use Oxygen\PassbookBundle\Form\Model\EventFormModel;

use Oxygen\FrameworkBundle\Controller\OxygenController;

/**
 * Controller to book
 * 
 * @author lolozere
 *
 */
class BookingController extends OxygenController
{
	/**
	 * Liste les évènements ouverts sur lesquels ajoutés des réservations
	 * 
	 * @author lolozere
	 */
	public function listEventsAction()
	{
		$grid_view = $this->get('oxygen_datagrid.loader')->getView(
				'oxygen_passbook_event_booking'
			);
		return $grid_view->getGridResponse('OxygenPassbookBundle:Booking:event_list.html.twig');
	}
	
	/**
	 * Liste les évènements ouverts sur lesquels ajoutés des réservations
	 *
	 * @author lolozere
	 */
	public function listBookingsAction($eventId)
	{
		// Get event
		$event = $this->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->getRepository()->find($eventId);
		if (is_null($event)) {
			throw $this->createNotFoundException($this->translate('oxygen_passbook.event.notfound', array('%id%' => $$eventId)));
		}
		// Get grid
		$grid_view = $this->get('oxygen_datagrid.loader')->getView(
				'oxygen_passbook_booking_person', array('eventId' => $eventId)
		);
		return $grid_view->getGridResponse('OxygenPassbookBundle:Booking:bookings.html.twig', array(
				'event' => $event
			));
	}
	/**
	 * Action to book on an event
	 * 
	 * @param integer $eventId Id of an event
	 * @param integer $id Id of booking person
	 */
	public function editBookingAction($eventId, $id= null) {
		// Get event
		$event = $this->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->getRepository()->find($eventId);
		if (is_null($event)) {
			throw $this->createNotFoundException($this->translate('oxygen_passbook.event.notfound', array('%id%' => $$eventId)));
		}
		
		$form = $this->get('oxygen_framework.form')->getForm('oxygen_passbook_booking_form', array(
				'eventId' => $eventId, 'bookingPersonId' => $id
			));
		if ($form->isSubmitted()) {
			if ($form->process()) {
				if (!is_null($id)) {
					return $this->redirect($this->generateUrl('oxygen_passbook_booking_list', array('eventId' => $eventId)));
				}
				return $this->redirect($this->generateUrl('oxygen_passbook_booking_event_list', array('eventId' => $eventId)));
			}
		}
		return $this->render('OxygenPassbookBundle:Booking:edit.html.twig', array('form' => $form->createView(), 'event' => $event));
	}
	/**
	 * Action for remove bookings of a person in an event
	 * 
	 * @param integer $eventId Id of an event
	 * @param integer $id Id of booking person
	 */
	public function deleteBookingsAction($eventId, $id) {
		$bookingPerson = $this->get('oxygen_framework.entities')->getManager('oxygen_passbook.booking_person')->getRepository()->find($id);
		if (is_null($bookingPerson)) {
			throw $this->createNotFoundException($this->get('translator')->trans('oxygen_passbook.booking_person.notfound', array('%id%' => $id)));
		}
		$this->get('oxygen_passbook.bookings')->removeBookings($bookingPerson, $eventId);
		$this->getDoctrine()->getEntityManager()->flush();
		$this->get('oxygen_framework.templating.messages')->addSuccess($this->translate('oxygen_passbook.booking.remove_bookings_event', array('%name%' => $bookingPerson->getName())));
		return $this->redirect($this->generateUrl('oxygen_passbook_booking_list', array('eventId' => $eventId)));
	}

}
