<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Formulaire d'édition d'un évènement
 * 
 * @author lolozere
 *
 */
class EventFormType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//throw new \Exception('get validation group');
		
		$builder->add('name', 'text', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('dateStart', 'datetime', array('required' => true, 'translation_domain' => 'oxygen_passbook_form', 'empty_value' => '-'));
		$builder->add('dateEnd', 'datetime', array('required' => true, 'translation_domain' => 'oxygen_passbook_form', 'empty_value' => '-'));
		$builder->add('tickets', 'collection', array(
				'type' => 'oxygen_passbook_event_ticket_type', 'by_reference' => false
			));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
				'translation_domain' => 'oxygen_passbook_form'
		));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_event_type';
	}
	
}