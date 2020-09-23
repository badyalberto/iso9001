<?php

namespace App\Form;

use App\Entity\Block;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Image;


class QuestionTestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, array(
                'required' => false,
                'attr' => ['name' => 'description']

            ))
            ->add('observaciones', TextareaType::class, array(
                'required' => false,
                'attr' => ['name' => 'observaciones']
            ))
            ->add('imagen', FileType::class, [
                'required' => false,
                'data_class' => null,
                'constraints' => [
                    new Image(),
                ]
            ])
            ->add('desactivar', CheckboxType::class, array(
                'required' => false,
                'label' => false,
                'attr' => ['name' => 'desactivar'],
                'label_attr' => ['class' => 'checkbox_custom']
            ))/*->
            add('no', ChoiceType::class, array(
                'required' => false,
                'expanded' => true,
                'multiple' => false,
                'label' => 'No'
            ))
            ->add('noimplementada', ChoiceType::class, array(
                'required' => false,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Funcionalidad no implementada'
            ))
            ->add('notesteado', ChoiceType::class, array(
                'required' => false,
                'expanded' => true,
                'multiple' => false,
                'label' => 'No testado'
            ))*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
