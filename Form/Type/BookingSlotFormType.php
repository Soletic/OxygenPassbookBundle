<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormView;

use Oxygen\FrameworkBundle\Form\Type\EntityEmbeddedFormType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\Options;

/**
 * Formulaire de choix d'un horaire pour une animation d'un évènement
 * 
 * @author lolozere
 *
 */
class BookingSlotFormType extends EntityEmbeddedFormType {
	
	public function buildView(FormView $view, FormInterface $form, array $options) {
		$view->vars['product'] = $options['product'];
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		// Transform
		parent::buildForm($builder, $options);
		
		$builder->add('eventProductSlot', 'oxygen_passbook_choice_slot_type', array(
				'required' => false, 'translation_domain' => 'oxygen_passbook_form',
				'product' => $options['product'], 'person_id' => $options['person_id']
			));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		parent::setDefaultOptions($resolver);
		$resolver->setRequired(array('product'));
		$resolver->setDefaults(array(
				'translation_domain' => 'oxygen_passbook_form',
				'person_id' => null,
			));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_booking_slot_type';
	}
	
}