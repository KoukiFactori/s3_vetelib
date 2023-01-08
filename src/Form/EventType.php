<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Event;
use App\Entity\TypeEvent;
use App\Entity\Veterinaire;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, options: [
                'label' => 'Description',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('date', DateTimeType::class, options: [
                'label' => 'Date',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('typeEvent', EntityType::class, options: [
                'class' => TypeEvent::class,
                'choice_label' => 'libType',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('typeevent')
                        ->orderBy('typevent.libType', 'ASC');
                },
            ])
            ->add('animal', EntityType::class, options: [
                'class' => Animal::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('animal')
                        ->orderBy('animal.name', 'ASC');
                },
            ])
            ->add('veterinaire', EntityType::class, options: [
                'class' => Veterinaire::class,
                'choice_label' => 'last_name',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('veterinaire')
                        ->orderBy('veterinaire.last_name', 'ASC')
                        ->orderBy('veterinaire.first_name', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
