<?php
namespace Oxygen\PassbookBundle\Validator;

use Oxygen\FrameworkBundle\Model\EntitiesServer;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MinSeatValidator extends ConstraintValidator
{
	/**
	 * @var EntitiesServer
	 */
	protected $entitiesServer;
	
	public function __construct($entitiesServer) {
		$this->entitiesServer = $entitiesServer;
	}
	
	public function validate($value, Constraint $constraint)
	{
		$bookingSlots = $this->entitiesServer->getManager('oxygen_passbook.booking_slot')->getRepository()->findByEventProductSlot($value->getId());
		if (count($bookingSlots) > $value->getSeatMax()) {
			$this->context->addViolationAt('seatMax', $constraint->message, array('%bookings%' => count($bookingSlots)));
		}
	}
}