<?php

namespace Plateforme\ProductBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
class BasketType extends AbstractType
{
	protected $name;

	public function __construct()
	{
		$this->name = 'plateforme_produitbundle_' .'paniertype';
	}


	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{


		$tableau=array();
		for($i=1; $i<=25; $i++){ 
			$tableau[$i]=$i;
		}

		$builder
		->add('name', HiddenType::class)
		->add('qte',ChoiceType::class, array('choices' => $tableau))


		;
	}


	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Plateforme\ProductBundle\Entity\Basket'
				));
	}
}
