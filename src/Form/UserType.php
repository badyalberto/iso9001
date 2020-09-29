<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Customer;

class UserType extends AbstractType
{
    const TYPES = ['WIIP' => 'WIIP', 'CLIENTE' => 'CLIENTE'];


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array(
                'required' => true
            ))
            ->add('correo', EmailType::class, array(
                'required' => true
            ))
            ->add('tipo', ChoiceType::class, array(
                'choices' => self::TYPES,
                'required' => true
            ))
            ->add('password', PasswordType::class, [
                'required' => $options['required_password'],
                'empty_data' => ''
            ])
            /*->add('customers', EntityType::class, [
                'label' => 'Clientes asignados',
                'class' => Customer::class,
                'choice_label' => 'alias',
                'multiple' => true,
                'required' => false
                //'attr' => ['class' => 'kt-dual-listbox']
                //'required' => false,
                //'by_reference' => false
            ])*/;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'required_password' => false
        ]);
    }
}