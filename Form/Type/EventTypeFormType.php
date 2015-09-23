<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Oxygen\FrameworkBundle\Form\Type\EntityEmbeddedFormType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulaire d'édition d'un type d'évènement (nature d'animation proposée dans l'évènement)
 * 
 * @author lolozere
 *
 */
class EventTypeFormType extends EntityEmbeddedFormType {
	
	protected $eventTypeClassName;
	/**
	 * @var Translator
	 */
	protected $translator;
	
	public function setEventTypeClassName($className) {
		$this->eventTypeClassName = $className;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		// Transform
		parent::buildForm($builder, $options);
		
		$builder->add('name', 'text', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		parent::setDefaultOptions($resolver);
		$resolver->setDefaults(array(
				'translation_domain' => 'oxygen_passbook_form'
		));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_event_type_type';
	}
	
}