<?php
namespace Oxygen\PassbookBundle\Form\Type;

use Symfony\Component\Translation\Translator;

use Symfony\Component\Form\Extension\Core\View\ChoiceView;

use Symfony\Component\Form\FormView;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\Intl\Locale\Locale;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\Form\FormInterface;

use Oxygen\FrameworkBundle\Model\EntitiesServer;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulaire de sélection d'un créneau horaire pour une animation
 * 
 * @author lolozere
 *
 */
class BookingSlotChoiceFormType extends AbstractType {
	
	/**
	 * 
	 * @var EntitiesServer
	 */
	protected $entitiesServer;
	/**
	 * @var Translator
	 */
	protected $translator;
	
	public function __construct($entitiesServer, $translator) {
		$this->entitiesServer = $entitiesServer;
		$this->translator = $translator;
	}
	
	public function buildView(FormView $view, FormInterface $form, array $options) {
		// Foreach slot, get availability
		foreach($view->vars['choices'] as $choice) {
			$choice instanceof ChoiceView;
			$sold = $this->entitiesServer->getManager('oxygen_passbook.booking_slot')->getRepository()->getTotalSeat($choice->data->getId(), $options['person_id']);
			$remaining = $choice->data->getSeatMax() - $sold;
			if ($remaining <= 0) {
				$choice->label = $this->translator->trans('form_book.slot.full', array('%label%' => $choice->label));
			} else {
				$choice->label = $this->translator->trans(
						$this->translator->transChoice('form_book.slot.remaining_one|form_book.slot.remaining', $remaining),
						array('%count%' => $remaining, '%label%' => $choice->label)
					);
			}
		}
		
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setRequired(array('product'));
		$resolver->setDefaults(array(
				'translation_domain' => 'oxygen_passbook_form',
				'class' => $this->entitiesServer->getManager('oxygen_passbook.event_product_slot')->getClassName(),
				'query_builder' => function (Options $options, $value) {
					$eventProductId = $options->get('product')->getId();
					return function($repository) use ($eventProductId) {
						return $repository->createQueryBuilder('slots')->innerJoin('slots.eventProduct', 'event_product')
							->where('event_product.id=:id')->setParameter('id', $eventProductId)
							->orderby('slots.dateStart');
					};
				},
				'expanded' => false,
				'multiple' => false,
				'required' => false,
				'empty_value' => 'Choisir un créneau horaire',
				'person_id' => null
			));
	}
	
	public function getParent()
	{
		return 'entity';
	}
	
	public function getName()
	{
		return 'oxygen_passbook_choice_slot_type';
	}
	
}