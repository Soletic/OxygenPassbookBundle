<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\Intl\DateFormatter\IntlDateFormatter;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Oxygen\FrameworkBundle\Form\Type\EntityEmbeddedFormType;

/**
 * Formulaire d'édition d'un ticket d'accès à un évènement
 * 
 * @author lolozere
 *
 */
class EventProductSlotFormType extends EntityEmbeddedFormType {
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder->add('dateStart', 'datetime', array(
				'required' => true, 'translation_domain' => 'oxygen_passbook_form',
				'widget' => 'single_text', 'with_seconds' => false,
				'attr' => array('placeholder' => \IntlDateFormatter::create('fr', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT)->getPattern()),
				'format' => \IntlDateFormatter::create('fr', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT)->getPattern(),
				'invalid_message' => 'La date est invalide',
			));
		$builder->add('dateEnd', 'datetime', array(
				'required' => true, 'translation_domain' => 'oxygen_passbook_form',
				'widget' => 'single_text', 'with_seconds' => false, 
				'attr' => array('placeholder' => \IntlDateFormatter::create('fr', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT)->getPattern()),
				'format' => \IntlDateFormatter::create('fr', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT)->getPattern(),
				'invalid_message' => 'La date est invalide',
			));
		$builder->add('seatMax', 'integer', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		parent::setDefaultOptions($resolver);
		 $resolver->setDefaults(array(
		 		'translation_domain' => 'oxygen_passbook_form'
		 ));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_event_product_slot_type';
	}
	
}