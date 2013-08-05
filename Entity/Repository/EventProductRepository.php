<?php
namespace Oxygen\PassbookBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Permet de retrouver des
 * @author lolozere
 *
 */
class EventProductRepository extends EntityRepository
{
	
	public function findAllsForBooking($eventId) {
		return $this->createQueryBuilder('product')->innerJoin('product.event', 'event')->where('event.id=:eventId')
			->setParameter('eventId', $eventId)->orderBy('product.name', 'ASC')->getQuery()->getResult();
	}
	
}