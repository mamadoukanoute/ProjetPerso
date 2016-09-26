<?php

namespace Api\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname',TextType::class)
        ->add('name',TextType::class)
        ->add('username',TextType::class)
        ->add('email',EmailType::class)
        ->add('password',TextType::class)
        ->add('password2',TextType::class)
        ->add('type', ChoiceType::class, array('choices' => array(
                'Client' => 'ROLE_CLIENT',
                'Seller' => 'ROLE_SELLER'
                ),))
                ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Api\UserBundle\Entity\User'
        ));
    }
}
