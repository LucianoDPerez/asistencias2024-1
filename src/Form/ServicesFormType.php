<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Service;
use App\Entity\ServiceType;
use App\Repository\ClientRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ServicesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    : void
    {
        /** @var TranslatorInterface $translator */
        $translator = $options['translator'];

        $builder
            ->add('client', EntityType::class, [
                'label' => 'Cliente',
                'class'=>Client::class,
                'choice_label'=>'name',
                'query_builder'=>function (ClientRepository $clientRepository) {
                    return $clientRepository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'placeholder'=>'Buscar...',
            ])
            ->add('serviceType', EntityType::class, [
                'label' => 'Tipo de Asistencia',
                'mapped' => false,
                'class' => ServiceType::class,
                'required' => true,
                'placeholder' => $translator->trans('Seleccionar tipo de asistencia'),
                'constraints' => [
                    new NotBlank(['message' => $translator->trans('backend.global.must_not_be_empty')]),
            ]])
            ->add('assignedDate', DateType::class, [
                'label' => 'Fecha Asignada',
                'widget'=>'choice',
                'data'=>new \DateTime(),
                'format'=>'dd-MM-yyyy',
                'html5'=>false
            ])
            ->add('assignedTime', TimeType::class, [
                'label' => 'Hora Asignada',
                'widget'=>'single_text',
                'html5'=>true,
                'data'=>new \DateTime(),
            ])
            ->add('description', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Desripcion'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    : void
    {
        $resolver->setRequired('translator');
        $resolver->setDefaults([
            'data_class'=>Service::class,
        ]);
    }
}
