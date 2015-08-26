<?php
namespace Oxygen\PassbookBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Permet de retrouver des
 * @author lolozere
 *
 */
class EventRepository extends EntityRepository
{
	/**
	 * Retourne la liste des évènements réservables
	 *
	 * @return array
	 */
	public function findEventsBookable()
	{
		return $this->createQueryBuilder("event")->where('event.opened=:opened')->setParameter('opened', true)
			->andWhere('event.bookingsClosed=:bookingClosed')->setParameter('bookingClosed', false)
			->getQuery()->getResult();
	}
	
}