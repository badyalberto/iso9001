<?php

namespace App\Form;

use App\Entity\Server;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServerType extends AbstractType
{
    const TYPES = ['Desarrollo' => 'Desarrollo', 'Produccion' => 'Produccion'];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('nombrevps',TextType::class,array(
                'required' => true
            ))
            ->add('alias',TextType::class,array(
                'required' => true
            ))
            ->add('ip',TextType::class,array(
                'required' => true
            ))
            ->add('urlacceso',TextType::class,array(
                'required' => true
            ))
            ->add('usuario',TextType::class,array(
                'required' => true
            ))
            ->add('psw',RepeatedType::class,
                [
                    'type'            => PasswordType::class,
                    'required'        => true,
                    //'first_options'   => ['label' => 'Password'],
                    //'second_options'  => ['label' => 'Repite Password'],
                    'invalid_message' => 'Los passwords deben coincidir!',
                    //'row_attr'        => ['class' => 'red']
                ])
            ->add('tipo',ChoiceType::class,array(
                'choices' => self::TYPES,
                'required' => true
            ))
            ->add('activo',CheckboxType::class,array(
                'required' => false,
                'label' => false,
                'label_attr' => ['class' => 'checkbox_custom']
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Server::class,
        ]);
    }
}
