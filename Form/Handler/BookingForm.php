<?php
namespace Oxygen\PassbookBundle\Form\Handler;

use Doctrine\Common\Collections\ArrayCollection;

use Oxygen\PassbookBundle\Form\Model\BookingPersonFormModel;

use Oxygen\PassbookBundle\Form\Model\BookingFormModel;

use Symfony\Component\Form\FormError;

use Oxygen\FrameworkBundle\Form\Form;

/**
 * Form to edit Event
 * 
 * @author lolozere
 *
 */
class BookingForm extends Form {
	/**
	 * 
	 * @var BookingFormModel
	 */
	protected $data = null;
	protected $event;
	/**
	 * Original booking slots for this event (and maybe person)
	 * 
	 * @var array
	 */
	protected $orignalSlots = array();
	
	public function getData() {
		if (is_null($this->data)) {
			$class = $this->getDataClass();
			$this->data = new $class();
		}
		return $this->data;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\FrameworkBundle\Form\Model.FormModelInterface::load()
	 */
	public function onLoad(array $params) {
		extract($params);
		
		// event
		if (!is_null($eventId)) {
			$this->event = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event')->getRepository()->find($eventId);
			if (is_null($this->event)) {
				throw (new NotFoundHttpException($this->container->get('translator')->trans('oxygen_passbook.event.notfound', array('%id%' => $eventId))));
			}
		} else {
			throw new \Exception("eventId arg require for form " . get_class($this));
		}
		
		// booking person
		if (!empty($bookingPersonId)) {
			$bookingPerson = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.booking_person')->getRepository()->find($bookingPersonId);
			if (is_null($bookingPerson)) {
				throw (new NotFoundHttpException($this->container->get('translator')->trans('oxygen_passbook.booking_person.notfound', array('%id%' => $bookingPersonId))));
			}
			$this->getData()->setPerson($bookingPerson);
			$this->options['person_id'] = $bookingPersonId;
		} else {
			$this->getData()->setPerson($this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.booking_person')->createInstance());
		}
		
		// Original booking slots for this event (and maybe person)
		foreach($this->getData()->getPerson()->getBookingSlots() as $bookingSlot) {
			if ($bookingSlot->getEventProductSlot()->getEventProduct()->getEvent()->getId() == $this->event->getId()) {
				$this->orignalSlots[] = $bookingSlot;
			}
		}
		
		// If event ticket already set
		if (!empty($params['eventTicket'])) {
			$this->options['hide_event_ticket'] = true;
			$this->options['max_animations'] = $params['eventTicket']->getLimitAnimations();
			$this->getData()->setEventTicket($params['eventTicket']);
		}
		
		// options of form
		$this->options['label'] = $this->event->getType().'.form.booking.slots_title';
		$this->options['person_options'] = array();
		$this->options['event'] = $this->event;
		$this->options['products'] = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.event_product')->getRepository()->findAllsForBooking($eventId);
		
		foreach($this->options['products'] as $index => $product) {
			$found = null;
			foreach($this->getData()->getPerson()->getBookingSlots() as $bookingSlot) {
				if ($bookingSlot->getEventProductSlot()->getEventProduct()->getId() == $product->getId()) {
					$found = $bookingSlot; 
				}
			}
			if (!is_null($found)) {
				$this->getData()->setBookingSlot($index, $found);
			} else {
				$this->getData()->setBookingSlot($index, $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.booking_slot')->createInstance());
			}
		}
		
		return $this;
	}
	/**
	 * Search unique person (or create) to registrer bookings
	 * 
	 */
	protected function getBookingPerson() {
		//Get booking person by email
		$bookingPerson =  $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.booking_person')->getRepository()->findOneBy(
				array('email' => $this->getData()->getPerson()->getEmail())
		);
		if (!is_null($bookingPerson)) {
			foreach($bookingPerson->getBookingSlots() as $bookingSlot) {
				if ($bookingSlot->getEventTicket()->getId() == $this->getData()->getEventTicket()->getId()) {
					$this->form->addError(new FormError('booking.errors.booking_exist', null, array(
							'%mail%' => $this->getData()->getPerson()->getEmail(),
							'%name%' => $this->options['event']->getName()
					)));
					break;
				}
			}
			// Transfer data to existing person
			$bookingPerson->setName($this->getData()->getPerson()->getName());
			$bookingPerson->setEmail($this->getData()->getPerson()->getEmail());
			$this->getData()->setPerson($bookingPerson);
		} else {
			$bookingPerson = $this->getData()->getPerson();
			$this->container->get('doctrine.orm.entity_manager')->persist($bookingPerson);
		}
		return $bookingPerson;
	}
	
	public function onSubmit() {
		
		if (empty($this->options['person_id'])) {
			$bookingPerson = $this->getBookingPerson();
		} else {
			$bookingPerson = $this->getData()->getPerson();
		}
		
		// Persist booking
		$totalSelected = 0; $hasErrors = false; $slotsSelected = new ArrayCollection();
		foreach($this->options['products'] as $index => $product) {
			$bookingSlot = $this->getData()->getBookingSlot($index);
			if (!is_null($bookingSlot->getEventProductSlot())) {
				// Ticket use
				$bookingSlot->setEventTicket($this->getData()->getEventTicket());
				// Check availability
				$sold = $this->container->get('oxygen_framework.entities')->getManager('oxygen_passbook.booking_slot')->getRepository()->getTotalSeat(
						$bookingSlot->getEventProductSlot()->getId(), $bookingPerson->getId()
					);
				$remaining = $bookingSlot->getEventProductSlot()->getSeatMax() - $sold;
				if ($remaining <= 0) {
					$this->form->get('bookingSlot_'.$index)->addError(new FormError('booking.errors.booking_full'));
					$hasErrors = true;
				}
				
				$totalSelected++;
				$bookingSlot->setBookingPerson($bookingPerson);
				
				if (is_null($bookingSlot->getId())) { // New booking
					$this->container->get('doctrine.orm.entity_manager')->persist($bookingSlot);
					$bookingPerson->addBookingSlot($bookingSlot);
					$slotsSelected[] = $bookingSlot;
				} else {// Pour une raison inconnue, l'entité est "détachée" de l'unit of work, on refresh alors
					$slotsSelected[] = $bookingPerson->refreshBookingSlot($bookingSlot);
				}
			}
		}
		
		$removed = $this->getRemovedElement($this->orignalSlots, $slotsSelected);
		foreach($removed as $bookingSlotRemoved) {
			$bookingPerson->removeBookingSlot($bookingSlotRemoved);
			$this->container->get('doctrine.orm.entity_manager')->remove($bookingSlotRemoved);
		}
		
		// Control animations limit
		if ($totalSelected <= 0) {
			$this->form->addError(new FormError('booking.errors.noselection'));
		} elseif ($totalSelected > $this->getData()->getEventTicket()->getLimitAnimations()) {
			$this->form->addError(new FormError('booking.errors.limit_animation|booking.errors.limit_animations', null, array('%max%' => $this->getData()->getEventTicket()->getLimitAnimations()), $this->getData()->getEventTicket()->getLimitAnimations()));
		}
		
		if (count($this->form->getErrors()) > 0 || $hasErrors) {
			return false;
		}
		
		return true;
	}
	
	public function onSuccess() {		
		$this->container->get('doctrine.orm.entity_manager')->flush();
		$this->container->get('oxygen_framework.templating.messages')->addSuccess(
				$this->container->get('translator')->trans('oxygen_passbook.booking.saved', array('%name%' => $this->options['event']->getName()))
			);
		return true;
	}
	
}