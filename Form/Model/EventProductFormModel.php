<?php
namespace Oxygen\PassbookBundle\Form\Model;

use Oxygen\PassbookBundle\Model\EventProductSlotInterface;

use Oxygen\FrameworkBundle\Form\Model\EntityEmbeddedInterface;

use Oxygen\PassbookBundle\Model\EventProductInterface;

use Oxygen\PassbookBundle\Model\EventProductModel;

class EventProductFormModel extends EventProductModel implements EntityEmbeddedInterface
{

	/**
	 * @var EventProductInterface
	 */
	protected $eventProduct;
	
	/**
	* @param EventProductInterface $eventProduct
	* @return EventProductFormModel
	*/
	public function setEntity($entity)
	{
	    $this->eventProduct = $entity;
	    return $this;
	}
	 
	/**
	* @return EventProductInterface
	*/
	public function getEntity()
	{
	    return $this->eventProduct;
	}

	public function getId()
	{
		return $this->eventProduct->getId();
	}

}
