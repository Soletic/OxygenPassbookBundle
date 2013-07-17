<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Formulaire d'édition d'un ticket d'accès à un évènement
 * 
 * @author lolozere
 *
 */
class EventTicketFormType extends AbstractType {
	
	protected $dataClass;
	
	public function __construct($dataClass) {
		$this->dataClass = $dataClass;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'text', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('limitAnimations', 'integer', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		 $resolver->setDefaults(array(
		 		'data_class' => $this->dataClass,
		 		'translation_domain' => 'oxygen_passbook_form'
		 ));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_event_ticket_type';
	}
	
}