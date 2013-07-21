<?php
namespace Oxygen\PassbookBundle\Booking\Exception;

class BookingsFoundException extends \Exception {
	
	protected $bookings;
	
	public function __construct($bookings) {
		$this->bookings = $bookings;
	}
	 
	/**
	* @return array
	*/
	public function getBookings()
	{
	    return $this->bookings;
	}
	/**
	 * 
	 * @param unknown_type $message
	 * @param array $bookings
	 * @return BookingsFoundException
	 */
	public static function create($message, array $bookings) {
		$exception = new self($bookings);
		$exception->message = $message;
		return $exception;
	}
}