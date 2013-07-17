<?php
namespace Oxygen\PassbookBundle\Model;
/**
 * Interface representing a ticket require to access event
 * 
 * @author lolozere
 *
 */
interface EventTicketInterface {
	/**
	 * Return id
	 * 
	 * @return int
	 */
	public function getId();
	/**
	 * Return the event
	 * 
	 * @return EventInterface
	 */
	public function getEvent();
	/**
	 * Return the max number of animations that could be booked
	 * 
	 * @return int
	 */
	public function getLimitAnimations();
	/**
	 * Return name of the ticket
	 * 
	 * @return string
	 */
	public function getName();
}