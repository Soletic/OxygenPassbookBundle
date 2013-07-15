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

	public function __construct(EventProductInterface $eventProduct)
	{
		$this->eventProduct = $eventProduct;
		$this->setName($eventProduct->getName());
		$this->setDescription($eventProduct->getDescription());
		$this->setUrl($eventProduct->getUrl());
	}

	public function getId()
	{
		return $this->eventProduct->getId();
	}

}
