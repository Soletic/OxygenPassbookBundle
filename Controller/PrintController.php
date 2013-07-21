<?php
namespace Oxygen\PassbookBundle\Controller;
use Oxygen\PassbookBundle\Form\Model\EventProductFormModel;

use Oxygen\PassbookBundle\Form\Model\EventFormModel;

use Oxygen\FrameworkBundle\Controller\OxygenController;

/**
 * Controller to book
 * 
 * @author lolozere
 *
 */
class PrintController extends OxygenController
{
	/**
	 * Liste les évènements ouverts sur lesquels faire des impressions
	 * 
	 * @author lolozere
	 */
	public function listEventsAction()
	{
		$grid_view = $this->get('oxygen_datagrid.loader')->getView(
				'oxygen_passbook_event_printing'
			);
		return $grid_view->getGridResponse('OxygenPassbookBundle:Print:event_list.html.twig');
	}
	
}
