<?php
namespace Oxygen\PassbookBundle\Model;

use Symfony\Component\Validator\ExecutionContext;

use Symfony\Component\Validator\ExecutionContextInterface;

use Oxygen\PassbookBundle\Model\EventProductSlotInterface;

/**
 * Slot (créneau horaire) of an event animation
 * 
 * @author lolozere
 *
 */
abstract class EventProductSlotModel implements EventProductSlotInterface {
	
	protected $id;
	protected $eventProduct;
	protected $dateStart;
	protected $dateEnd;
	protected $seatMax = 1;
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductSlotInterface::getId()
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	* @param EventProductInterface $eventProduct
	* @return EventProductSlotModel
	*/
	public function setEventProduct(EventProductInterface $eventProduct)
	{
	    $this->eventProduct = $eventProduct;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductSlotInterface::getEventProduct()
	 */
	public function getEventProduct()
	{
	    return $this->eventProduct;
	}
	
	/**
	* @param \DateTime $dateStart
	* @return EventProductSlotModel
	*/
	public function setDateStart($dateStart)
	{
	    $this->dateStart = $dateStart;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductSlotInterface::getDateStart()
	 */
	public function getDateStart()
	{
	    return $this->dateStart;
	}

	/**
	* @param \DateTime $dateEnd
	* @return EventProductSlotModel
	*/
	public function setDateEnd($dateEnd)
	{
	    $this->dateEnd = $dateEnd;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductSlotInterface::getDateEnd()
	 */
	public function getDateEnd()
	{
	    return $this->dateEnd;
	}
	
	/**
	* @param integer $seatMax
	* @return EventProductSlotModel
	*/
	public function setSeatMax($seatMax)
	{
	    $this->seatMax = $seatMax;
	    return $this;
	}
	 
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\PassbookBundle\Model.EventProductSlotInterface::getSeatMax()
	 */
	public function getSeatMax()
	{
	    return $this->seatMax;
	}
	
	public function isDateValid(ExecutionContextInterface $context)
    {
        if (!is_null($this->dateStart) && !is_null($this->dateEnd)) {
        	if ($this->dateStart->format('Y-m-d H:i') > $this->dateEnd->format('Y-m-d H:i')) {
        		$context->addViolationAt('dateStart', 'event_slot.errors.date');
        	}
        }
    }
	
}