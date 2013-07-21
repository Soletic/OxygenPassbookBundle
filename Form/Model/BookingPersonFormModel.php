<?php
namespace Oxygen\PassbookBundle\Form\Model;

use Oxygen\PassbookBundle\Model\BookingPersonModel;

use Oxygen\FrameworkBundle\Form\Model\EntityEmbeddedInterface;

/**
 * Model for booking on a slot
 * 
 * @author lolozere
 *
 */
class BookingPersonFormModel extends BookingPersonModel implements EntityEmbeddedInterface {
	
	/**
	 * @var BookingPersonInterface
	 */
	protected $entity;
	
	/**
	 * @param BookingPersonInterface $event
	 * @return BookingPersonFormModel
	 */
	public function setEntity($entity)
	{
		$this->entity = $entity;
		return $this;
	}
	
	/**
	 * @return BookingPersonInterface
	 */
	public function getEntity()
	{
		return $this->entity;
	}
	
	
	public function getId()
	{
		return $this->entity->getId();
	}
	
	
}