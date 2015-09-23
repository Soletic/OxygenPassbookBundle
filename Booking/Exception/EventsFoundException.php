<?php
namespace Oxygen\PassbookBundle\Booking\Exception;

class EventsFoundException extends \Exception {
	
	protected $events;
	
	public function __construct($events) {
		$this->events = $events;
	}
	 
	/**
	* @return array
	*/
	public function getEvents()
	{
	    return $this->events;
	}
	/**
	 * 
	 * @param unknown_type $message
	 * @param array $bookings
	 * @return BookingsFoundException
	 */
	public static function create($message, array $events) {
		$exception = new self($events);
		$exception->message = $message;
		return $exception;
	}
}