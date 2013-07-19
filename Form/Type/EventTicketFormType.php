<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Oxygen\FrameworkBundle\Form\Type\EntityEmbeddedFormType;

/**
 * Formulaire d'édition d'un ticket d'accès à un évènement
 * 
 * @author lolozere
 *
 */
class EventTicketFormType extends EntityEmbeddedFormType {
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder->add('name', 'text', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('limitAnimations', 'integer', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		parent::setDefaultOptions($resolver);
		 $resolver->setDefaults(array(
		 		'translation_domain' => 'oxygen_passbook_form'
		 ));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_event_ticket_type';
	}
	
}