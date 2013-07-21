<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormView;

use Oxygen\FrameworkBundle\Form\Type\EntityEmbeddedFormType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulaire d'édition d'un produit dans évènement
 * 
 * @author lolozere
 *
 */
class EventProductFormType extends EntityEmbeddedFormType {
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder->add('name', 'text', array('required' => true, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('description', 'textarea', array('required' => false, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('url', 'url', array('required' => false, 'translation_domain' => 'oxygen_passbook_form'));
		$builder->add('slots', 'collection', array('type'=> 'oxygen_passbook_event_product_slot_type', 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		parent::setDefaultOptions($resolver);
		$resolver->setDefaults(array(
				'translation_domain' => 'oxygen_passbook_form'
		));
	}
	
	public function getName()
	{
		return 'oxygen_passbook_event_product_type';
	}
	
}