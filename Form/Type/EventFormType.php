<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Oxygen\FrameworkBundle\Form\Type\EntityEmbeddedFormType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulaire d'édition d'un évènement
 * 
 * @author lolozere
 *
 */
class EventFormType extends EntityEmbeddedFormType {
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		// Transform
		parent::buildForm($builder, $options);
		
		$builder->add('name', 'text', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('dateStart', 'datetime', array('required' => true, 'translation_domain' => 'oxygen_passbook_form', 'empty_value' => '-'));
		$builder->add('dateEnd', 'datetime', array('required' => true, 'translation_domain' => 'oxygen_passbook_form', 'empty_value' => '-'));
		$builder->add('tickets', 'collection', array(
				'type' => 'oxygen_passbook_event_ticket_type', 'by_reference' => false, 'allow_add' => true, 'allow_delete' => true,
			));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		parent::setDefaultOptions($resolver);
		$resolver->setDefaults(array(
				'translation_domain' => 'oxygen_passbook_form'
		));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_event_type';
	}
	
}