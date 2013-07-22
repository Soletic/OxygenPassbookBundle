<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Oxygen\FrameworkBundle\Locale\Locale;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

class FilterBookingsFormType extends AbstractType {
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
		$builder->add('dateMin', 'datetime', array(
				'required' => false, 'translation_domain' => 'oxygen_passbook_form',
				'widget' => 'single_text', 'with_seconds' => false,
				'attr' => array('placeholder' => \IntlDateFormatter::create('fr', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT)->getPattern()),
				'format' => \IntlDateFormatter::create(Locale::getDefault(), \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT)->getPattern(),
				'invalid_message' => 'La date est invalide',
				'label' => 'form.filter_bookings.date_min',
			));
		$builder->add('dateMax', 'datetime', array(
				'required' => false, 'translation_domain' => 'oxygen_passbook_form',
				'widget' => 'single_text', 'with_seconds' => false,
				'attr' => array('placeholder' => \IntlDateFormatter::create('fr', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT)->getPattern()),
				'format' => \IntlDateFormatter::create(Locale::getDefault(), \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT)->getPattern(),
				'invalid_message' => 'La date est invalide',
				'label' => 'form.filter_bookings.date_max',
			));

	}
	
	public function getName() {
		return 'oxygen_passbook_filter_bookings_type';
	}

	
}