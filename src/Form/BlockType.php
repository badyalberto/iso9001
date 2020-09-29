<?php

namespace App\Form;

use App\Entity\Block;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'required' => false
            ))
            ->add('position', IntegerType::class, array(
                'required' => false
            ))
            ->add('bloque_padre', ChoiceType::class, array(
                'choices' => self::TYPES,
                'required' => true,

            ))/*->add('questions', CollectionType::class, [
                'entry_type' => QuestionTestType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true
            ])*/;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Block::class,
        ]);
    }
}
