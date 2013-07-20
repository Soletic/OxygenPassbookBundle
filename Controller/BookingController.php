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

}
