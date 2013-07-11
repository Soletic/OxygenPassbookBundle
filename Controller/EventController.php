<?php

namespace Oxygen\PassbookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controller with actions to manage Event
 * 
 * @author lolozere
 *
 */
class EventController extends Controller
{
    public function listEventsAction() {
    	// Solution 1 - Use default configurator sets in config
    	$grid_view = $this->get('oxygen_datagrid.templating')->getEntityView('oxygen_passbook.event');
    	
    	return $grid_view->getGridResponse('OxygenPassbookBundle:Event:list.html.twig');
    }
}
