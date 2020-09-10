<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Project;
use App\Entity\Test;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    const STATUS = ['Realizado' => 'Realizado', 'Iniciado' => 'Iniciado', 'No Iniciado' => 'No Iniciado'];
    const TYPES = ['ALPHA' => 'ALPHA', 'BETA' => 'BETA'];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alias', TextType::class, array(
                'required' => true
            ))
            ->add('customer', EntityType::class, [
                //'label' => 'Clientes asignados',
                'class' => Customer::class,
                'choice_label' => 'alias',
                'multiple' => false,
                'required' => true,
                'by_reference' => false
            ])
            ->add('project', EntityType::class, [
                //'label' => 'Clientes asignados',
                'class' => Project::class,
                'choice_label' => 'alias',
                'multiple' => false,
                'required' => true,
                'by_reference' => false
            ])
            ->add('tipo', ChoiceType::class, array(
                'choices' => self::TYPES,
                'required' => true
            ))
            ->add('usuario', TextType::class, array(
                'required' => true
            ))
            ->add('password', PasswordType::class, array(
                'required' => true
            ))
            ->add('estado', ChoiceType::class, array(
                'choices' => self::STATUS,
                'required' => true
            ))
            ->add('desactivar', CheckboxType::class, [
                'required' => false,
                'label' => false,
                'label_attr' => ['class' => 'checkbox_custom']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
