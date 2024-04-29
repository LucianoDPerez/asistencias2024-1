<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Plan;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ClientType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    : void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Name',
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('address', TextType::class, [
                'label'=>'Address',
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('phone', TextType::class, [
                'label'=>'Phone',
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('service', TextType::class, [
                'label'=>'Service',
                'required'=>false,
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('ip', TextType::class, [
                'label'=>'IP',
                'required'=>false,
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}