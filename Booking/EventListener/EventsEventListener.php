<?php
namespace Oxygen\PassbookBundle\Booking\EventListener;

use Oxygen\PassbookBundle\Booking\Exception\BookingsFoundException;

use Oxygen\FrameworkBundle\Model\EntitiesServer;

use Oxygen\FrameworkBundle\Model\EntityEvents;

use Oxygen\FrameworkBundle\Model\Event\ModelEvent;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventsEventListener implements EventSubscriberInterface {
	
	/**
	 * @var EntitiesServer
	 */
	protected $entitiesServer;
	
	public function __construct($entitiesServer) {
		$this->entitiesServer = $entitiesServer;
	}
	
	public static function getSubscribedEvents() {
		return array(
				EntityEvents::beforeRemove('oxygen_passbook.event_product') => 'onRemoveEventProduct',
				EntityEvents::beforeRemove('oxygen_passbook.event') => 'onRemoveEvent',
				EntityEvents::beforeRemove('oxygen_passbook.event_product_slot') => 'onRemoveEventProductSlot',
			);
	}
	
	public function onRemoveEventProduct(ModelEvent $event) {
		$bookings = $this->entitiesServer->getManager(('oxygen_passbook.booking_slot'))->getRepository()->findByEventProduct($event->getModel()->getId());
		if (count($bookings) > 0) {
			throw BookingsFoundException::create(sprintf("Impossible to remove event product %d because bookings exist", $event->getModel()->getId()), $bookings);
		}
	}
	
	public function onRemoveEvent(ModelEvent $event) {
		$bookings = $this->entitiesServer->getManager(('oxygen_passbook.booking_slot'))->getRepository()->findByEvent($event->getModel()->getId());
		if (count($bookings) > 0) {
			throw BookingsFoundException::create(sprintf("Impossible to remove event %d because bookings exist", $event->getModel()->getId()), $bookings);
		}
	}
	
	public function onRemoveEventProductSlot(ModelEvent $event) {
		$bookings = $this->entitiesServer->getManager(('oxygen_passbook.booking_slot'))->getRepository()->findByEventProductSlot($event->getModel()->getId());
		if (count($bookings) > 0) {
			throw BookingsFoundException::create(sprintf("Impossible to remove event product slot %d because bookings exist", $event->getModel()->getId()), $bookings);
		}
	}
	
}