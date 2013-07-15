<?php
namespace Oxygen\PassbookBundle\Model;

/**
 * Interface implemented to represent event
 * 
 * @author lolozere
 *
 */
interface EventInterface {
	/**
	 * @return integer
	 */
	public function getId();
	/**
	 * Name of the pass. Example : Pass Bien-être 2013
	 * 
	 * @return string
	 */
	public function getName();
	/**
	 * 
	 * @param string $name
	 */
	public function setName($name);
	/**
	 * Date start of the event access
	 * 
	 * @return \DateTime
	 */
	public function getDateStart();
	/**
	 * 
	 * @param \DateTime $dateStart
	 */
	public function setDateStart($dateStart);
	/**
	 * Date end of the event access
	 *
	 * @return \DateTime
	 */
	public function getDateEnd();
	/**
	 * 
	 * @param \DateTime $dateEnd
	 */
	public function setDateEnd($dateEnd);
	/**
	 * Return products in the event
	 * 
	 * @return array
	 */
	public function getProducts();
	/**
	 * Add product to the event
	 * 
	 * @param EventProductInterface $product
	 * @return EventInterface
	 */
	public function addProduct(EventProductInterface $product);
	/**
	 * Remove product to the event
	 * 
	 * @param EventProductInterface $product
	 * @return EventInterface
	 */
	public function removeProduct(EventProductInterface $product);
}