<?php

namespace Plateforme\ProduitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Plateforme\ProduitBundle\Entity\Categories;

class ProduitsType extends AbstractType
{
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
		->add('nom',TextType::class)
		->add('description',TextareaType::class, array('attr' => array('class' => 'ckeditor')))
		->add('qte',ChoiceType::class,array('choices' => $tableau))
		->add('prix',TextType::class)

		->add('catid',ChoiceType::class, array('choices' => array(
				'Produits laitiers' => '1','Boucherie' => '2','Entretien Maison' => '3','Hygiène'=>'4','Boissons'=>'5','Conserves'=>'6',
				'Boulangerie'=>'7','Produits Frais'=>'8','Chocolat'=>'9',

				),))
				->add('file',FileType::class,array('required'=> false,))
				;
	}



	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Plateforme\ProduitBundle\Entity\Produits'
				));
	}
}
