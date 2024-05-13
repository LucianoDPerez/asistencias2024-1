<?php

namespace App\Form;

use App\Entity\ServiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ServiceFormTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var TranslatorInterface $translator */
        $translator = $options['translator'];

        $builder
            ->add('name')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('translator');
        $resolver->setDefaults([
            'data_class' => ServiceType::class,
        ]);
    }
}
