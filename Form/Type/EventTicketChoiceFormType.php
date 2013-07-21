<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\Intl\Locale\Locale;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\Form\FormInterface;

use Oxygen\FrameworkBundle\Model\EntitiesServer;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulaire de sélection d'un créneau horaire pour une animation
 * 
 * @author lolozere
 *
 */
class EventTicketChoiceFormType extends AbstractType {
	
	/**
	 * 
	 * @var EntitiesServer
	 */
	protected $entitiesServer;
	
	public function __construct($entitiesServer) {
		$this->entitiesServer = $entitiesServer;
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setRequired(array('event'));
		$resolver->setDefaults(array(
				'translation_domain' => 'oxygen_passbook_form',
				'class' => $this->entitiesServer->getManager('oxygen_passbook.event_ticket')->getClassName(),
				'query_builder' => function (Options $options, $value) {
					$eventId = $options->get('event')->getId();
					return function($repository) use ($eventId) {
						return $repository->createQueryBuilder('event_ticket')->innerJoin('event_ticket.event', 'event')
							->where('event.id=:id')->setParameter('id', $eventId);
					};
				},
				'expanded' => false,
				'multiple' => false,
				'required' => false,
			));
	}
	
	public function getParent()
	{
		return 'entity';
	}
	
	public function getName()
	{
		return 'oxygen_passbook_choice_event_ticket_type';
	}
	
}