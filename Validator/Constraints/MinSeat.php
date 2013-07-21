<?php
namespace Oxygen\PassbookBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class MinSeat extends Constraint {
	
	public $message = '%bookings% réservations existent déjà et le nombre de places doit donc au moins être de %bookings%';
	
	public function validatedBy()
	{
		return 'oxygen_passbook.validator.min_seat';
	}

	public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
	
}