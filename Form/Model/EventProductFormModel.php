<?php
namespace Oxygen\PassbookBundle\Form\Model;

use Oxygen\PassbookBundle\Model\EventProductInterface;

use Oxygen\PassbookBundle\Model\EventProductModel;

class EventProductFormModel extends EventProductModel
{

	/**
	 * @var EventProductInterface
	 */
	protected $eventProduct;
	
	/**
	* @param EventProductInterface $eventProduct
	* @return EventProductFormModel
	*/
	public function setEventProduct($eventProduct)
	{
	    $this->eventProduct = $eventProduct;
	    $this->setName($eventProduct->getName());
	    $this->setDescription($eventProduct->getDescription());
	    $this->setUrl($eventProduct->getUrl());
	    return $this;
	}
	 
	/**
	* @return EventProductInterface
	*/
	public function getEventProduct()
	{
	    return $this->eventProduct;
	}


	public function getId()
	{
		return $this->eventProduct->getId();
	}

}
