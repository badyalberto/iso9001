<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\User;

class CustomerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array(
                'label' => 'Nombre',
                'required' => true
            ))
            ->add('alias', TextType::class, array(
                'label' => 'Alias',
                'required' => true
            ))
            ->add('pmnombre', TextType::class, array(
                'label' => 'Persona de Contacto',
                'required' => true
            ))
            ->add('pmmail', EmailType::class, array(
                'label' => 'Correo electronico de Contacto',
                'required' => true
            ))
            /*->add('users', EntityType::class, [
                'label' => 'Usuarios asignados',
                'class' => User::class,
                'choice_label' => 'nombre',
                'multiple' => true,
                //'by_reference' => false
                //'attr' => ['class' => 'kt-dual-listbox', 'id' => 'kt-dual-listbox-2']
                //'expanded' => true,
            ])*/
            /*->add('estado', CheckboxType::class, [
                'required' => false,
                'label' => false,
                'label_attr' => ['class' => 'checkbox_custom']
            ])*/;/*->add('submit', SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary float-left'],
                'label' => 'Guardar'
            ])
            ->add('cancel', ResetType::class, [
                'attr' => ['class' => 'btn btn-warning float-right'],
                'label' => 'Cancelar'
            ])*/
    }
}