<?php

namespace App\Form;

use App\Entity\Customer;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\User;
use App\Entity\Project;
use Symfony\Component\Validator\Constraints\Date;

class ProjectType extends AbstractType
{
    const TYPES = ['Symfony' => 'Symfony', 'Wordpress' => 'Wordpress','Prestashop' => 'Prestashop','SEO' => 'SEO','Social Media' => 'Social Media'];
    const STATUS = ['ALPHA' => 'ALPHA', 'BETA' => 'BETA','PRODUCCION' => 'PRODUCCION','CERRADO A TESTING' => 'CERRADO A TESTING'];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaalta', DateType::class,array(
                'label' => 'Fecha de Alta',
                'required'=>true
            ))
            ->add('customers', EntityType::class,array(
                'label' => 'Cliente',
                'class' => Customer::class,
                'choice_label' => 'alias',
                'multiple' => false,
                'required' => true
            ))
            ->add('alias', TextType::class,array(
                'label' => 'Alias de Proyecto',
                'required'=>true
            ))
            ->add('tipo', ChoiceType::class,array(
                'choices' => self::TYPES,
                'required' => true
            ))
            ->add('urltest', TextType::class,array(
                'label' => 'URL Test',
                'required'=>true
            ))
            ->add('urlproduction', TextType::class,array(
                'label' => 'URL Producción',
                'required'=>true
            ))
            ->add('manager_wip', EntityType::class,array(
                'label' => 'Project Manager WIP',
                'class' => User::class,
                'choice_label' => 'nombre',
                'multiple' => true,
                'required' => true,
                'query_builder' => function(UserRepository $us){
                    return $us->createQueryBuilder('u')
                        ->Where('u.tipo = :WIIP')
                        ->setParameter('WIIP', 'WIIP');
                }
            ))
            ->add('manager_customer', EntityType::class,array(
                'label' => 'Project Manager Cliente',
                'class' => User::class,
                'choice_label' => 'nombre',
                'multiple' => true,
                'required' => true,
                'query_builder' => function(UserRepository $us){
                    return $us->createQueryBuilder('u')
                        ->where('u.tipo = :CLIENTE')
                        ->setParameter('CLIENTE', 'CLIENTE');
                }

            ))
            ->add('estado', ChoiceType::class,[
                'choices' => self::STATUS,
                'required' => true
            ])
            ->add('desactivar', CheckboxType::class,[
                'label'    => 'Desactivar Proyecto',
                'label' => false,
                'required' => false
            ]);

    }
}