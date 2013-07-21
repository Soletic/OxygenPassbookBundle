<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Formulaire d'édition d'un produit dans évènement
 * 
 * @author lolozere
 *
 */
class BookingFormType extends AbstractType {
	
	public function buildView(FormView $view, FormInterface $form, array $options) {
		$view->vars['event'] = $options['event'];
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('eventTicket', 'oxygen_passbook_choice_event_ticket_type', array(
				'required' => true, 'translation_domain' => 'oxygen_passbook_form', 'event' => $options['event']
		));
		
		$builder->add('person', 'oxygen_passbook_booking_person_type', array(
				'required' => true, 'translation_domain' => 'oxygen_passbook_form',
			));
		
		foreach($options['products'] as $i => $eventProduct) {
			$builder->add('bookingSlot_'.$i, 'oxygen_passbook_booking_slot_type', array(
					'product' => $eventProduct, 'label' => $eventProduct->getName(),
					'required' => false, 'translation_domain' => 'oxygen_passbook_form',
					'by_reference' => false, 'error_bubbling' => false, 'person_id' => $options['person_id'],
			));
		}
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setRequired(array('products'));
		$resolver->setRequired(array('event'));
		$resolver->setDefaults(array(
				'translation_domain' => 'oxygen_passbook_form',
				'cascade_validation' => true,
				'limit_animations' => null,
				'error_bubbling' => false,
				'person_id' => null,
			));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_booking_type';
	}
	
}