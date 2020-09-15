<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Project;
use App\Entity\Test;
use App\Entity\User;
use App\Repository\CustomerRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Cassandra\Custom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    const TYPES = ['ALPHA' => 'ALPHA', 'BETA' => 'BETA'];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alias', TextType::class, array(
                'required' => true
            ))
            ->add('customer', EntityType::class, [
                'label' => 'Cliente',
                'class' => Customer::class,
                'choice_label' => 'alias',
                'multiple' => false,
                'required' => false,
                'query_builder' => function (CustomerRepository $c) {
                    return $c->createQueryBuilder('c')
                        ->leftJoin('c.projects', 'p') //P es proyecto que lo reconoce por el tipo de array
                        ->where('p is not NULL');
                }
            ])
            ->add('project', EntityType::class, [
                'label' => 'Proyecto',
                'class' => Project::class,
                'choice_label' => 'alias',
                'multiple' => false,
                'required' => false
                //'attr' => ['class' => 'kt-dual-listbox']
            ])
            ->add('tipo', ChoiceType::class, array(
                'choices' => self::TYPES,
                'required' => true
            ))
            ->add('user', EntityType::class, [
                'label' => 'Usuario Test',
                'class' => User::class,
                'choice_label' => 'correo',
                'multiple' => false,
                'required' => true
                //'attr' => ['class' => 'kt-dual-listbox']
            ])
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
