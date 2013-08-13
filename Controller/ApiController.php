<?php
namespace Oxygen\PassbookBundle\Controller;
use Doctrine\ORM\AbstractQuery;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Response;

use Oxygen\FrameworkBundle\Controller\OxygenController;

/**
 * Controller of API Actions
 * 
 * @author lolozere
 *
 */
class ApiController extends OxygenController
{
	/**
	 * Liste les créneaux horaires d'une animation
	 * 
	 * @author lolozere
	 */
	public function availabilityAction()
	{
		$urlCard = $this->getRequest()->get('url', null);
		$animationsId = $this->getRequest()->get('animationsId', null);
		if (is_null($urlCard) && is_null($animationsId)) {
			return JsonResponse::create(null);
		}
		
		// Search event product with this url
		$slots = $this->getEntitiesServer()->getManager('oxygen_passbook.event_product_slot')->getRepository()
			->createQueryBuilder('slot')->innerJoin('slot.eventProduct', 'event_product')
			->select('event_product.name as name, slot.id as slotId, slot.dateStart as dateStart, slot.dateEnd as dateEnd, slot.seatMax as seatMax')
			->orderBy('event_product.id', 'ASC')
			->addOrderBy('slot.dateStart', 'ASC');
		
		if (!is_null($animationsId)) {
			$slots->where($slots->expr()->in('event_product.id', explode(',', $animationsId)));
		} else {
			$slots->where('event_product.url=:url')->setParameter('url', $urlCard);
		}
		
		$slots = $slots->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
		
		$availability = array();
		
		$previousEventProduct = null;
		foreach($slots as $slot) {
			if ($previousEventProduct != $slot['name']) {
				$availability[] = array('name' => $slot['name'], 'slots' => array());
				$previousEventProduct = $slot['name'];
			}
			$date = $slot['dateStart']->format('j M Y');
			if (empty($availability[count($availability)-1]['slots'][$date])) {
				$availability[count($availability)-1]['slots'][$date] = array();
			}
			
			// Check full
			$sold = $this->getEntitiesServer()->getManager('oxygen_passbook.booking_slot')->getRepository()->getTotalSeat($slot['slotId']);
			$remaining = $slot['seatMax'] - $sold;
			$full = false;
			if ($remaining <= 0)
				$full = true;
			
			$availability[count($availability)-1]['slots'][$date][] = array(
					'full' => $full, 'hour' => $slot['dateStart']->format('H:i') . ' > ' . $slot['dateEnd']->format('H:i')
				);
			
		}
		return JsonResponse::create($availability);
	}
	
}
