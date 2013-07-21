<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Oxygen\FrameworkBundle\Form\Type\EntityEmbeddedFormType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulaire d'édition d'une personne réservant
 * 
 * @author lolozere
 *
 */
class BookingPersonFormType extends EntityEmbeddedFormType {
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		// Transform
		parent::buildForm($builder, $options);
		
		$builder->add('name', 'text', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('email', 'email', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		parent::setDefaultOptions($resolver);
		$resolver->setDefaults(array(
				'translation_domain' => 'oxygen_passbook_form'
		));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_booking_person_type';
	}
	
}