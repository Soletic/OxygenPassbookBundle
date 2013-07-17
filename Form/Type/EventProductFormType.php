<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Formulaire d'édition d'un produit dans évènement
 * 
 * @author lolozere
 *
 */
class EventProductFormType extends AbstractType {
	
	protected $dataClass;
	
	public function __construct($dataClass) {
		$this->dataClass = $dataClass;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'text', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('description', 'textarea', array('required' => false, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('url', 'url', array('required' => false, 'translation_domain' => 'oxygen_passbook_form'));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
				'data_class' => $this->dataClass,
				'translation_domain' => 'oxygen_passbook_form'
		));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_event_product_type';
	}
	
}