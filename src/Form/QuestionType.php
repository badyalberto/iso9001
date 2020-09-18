<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Image;


class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, array(
                'required' => true,
                'attr' => ['name' => 'description']

            ))
            ->add('observaciones', TextareaType::class, array(
                'required' => true,
                'attr' => ['name' => 'observaciones']
            ))
            ->add('imagen', FileType::class, [
                'required' => true,
                'constraints' => [
                    new Image(),
                ]
            ])
            ->add('desactivar', CheckboxType::class, array(
                'required' => false,
                'label' => false,
                'attr' => ['name' => 'desactivar'],
                'label_attr' => ['class' => 'checkbox_custom']
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
