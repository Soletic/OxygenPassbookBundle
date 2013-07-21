<?php
namespace Oxygen\PassbookBundle\Form\Model;

use Oxygen\FrameworkBundle\Form\Model\EntityEmbeddedInterface;

use Oxygen\PassbookBundle\Model\BookingSlotModel;

/**
 * Model for booking on a slot
 * 
 * @author lolozere
 *
 */
class BookingSlotFormModel extends BookingSlotModel implements EntityEmbeddedInterface {
	
	/**
	 * @var EventInterface
	 */
	protected $entity;
	
	/**
	 * @param BookingSlotInterface $event
	 * @return BookingSlotFormModel
	 */
	public function setEntity($entity)
	{
		$this->entity = $entity;
		return $this;
	}
	
	/**
	 * @return BookingSlotInterface
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