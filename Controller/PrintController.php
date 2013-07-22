<?php
namespace Oxygen\PassbookBundle\Controller;
use Oxygen\FrameworkBundle\Locale\Locale;

use Oxygen\PassbookBundle\Form\Type\FilterBookingsFormType;

use Symfony\Component\HttpFoundation\Response;

use Oxygen\PassbookBundle\Form\Model\EventProductFormModel;

use Oxygen\PassbookBundle\Form\Model\EventFormModel;

use Oxygen\FrameworkBundle\Controller\OxygenController;

/**
 * Controller to book
 * 
 * @author lolozere
 *
 */
class PrintController extends OxygenController
{
	
	/**
	 * List bookings of an animation
	 * 
	 * @param string $key Key for securisation
	 * @param integer $id Event product id
	 */
	public function bookingsAnimationAction($key, $id) {
		if ($key != $this->container->getParameter('secret')) {
			return Response::create('Accès interdit');
		}
		
		// Get event product
		$eventProduct = $this->getEntitiesServer()->getManager('oxygen_passbook.event_product')->getRepository()->find($id);
		if (is_null($eventProduct)) {
			throw $this->createNotFoundException($this->translate('oxygen_passbook.event.notfound', array('%id%' => $id)));
		}
		
		// Get bookings
		$bookings = null;
		$data = array('dateMin' => null, 'dateMax' => null);
		
		// form to filter
		$form = $this->createForm(new FilterBookingsFormType());
		$form->handleRequest($this->getRequest());
		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				$data = $form->getData();
				$bookings = $this->getEntitiesServer()->getManager('oxygen_passbook.booking_slot')->getRepository()->findByEventProduct(
						$id, $data['dateMin'], $data['dateMax']
					);
			}
		}
		
		if (is_null($bookings)) {
			$bookings = $this->getEntitiesServer()->getManager('oxygen_passbook.booking_slot')->getRepository()->findByEventProduct($id);
		}
		
		return $this->render('OxygenPassbookBundle:Print:bookings.html.twig', array(
				'filter' => $data, 'bookings' => $bookings, 'eventProduct' => $eventProduct, 'form' => $form->createView(),
				'date_pattern' => 'd/m/Y H:i'
			));
	}
	
}
