<?php

namespace App\Form;

use App\Entity\Block;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlockType extends AbstractType
{
    const TYPES = ['No' => 'No', 'Diseño Avisos' => 'Diseño Avisos', 'Diseño Alertas' => 'Diseño Alertas'];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('alias', TextType::class, array(
                'required' => true
            ))
            ->add('position', IntegerType::class, array(
                'required' => true
            ))
            ->add('bloque_padre', ChoiceType::class, array(
                'choices' => self::TYPES,
                'required' => false,
                'empty_data' => '',

            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Block::class,
        ]);
    }
}
