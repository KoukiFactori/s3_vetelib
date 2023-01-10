<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\TypeEvent;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animal', EntityType::class, options: [
                'label' => 'Selectionner un animal',
                'class' => Animal::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $entityRepository) use ($options) {
                    return $entityRepository->createQueryBuilder('animal')
                        ->where('animal.client = :clientId')
                        ->setParameter('clientId', $options['clientId'])
                        ->orderBy('animal.name', 'ASC');
                }
            ])
            ->add('date', DateType::class, options: [
                'label' => 'Choisir une date',
                'widget' => 'single_text',
                'html5' => false,
                'data' => new \DateTime(),
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'js-datepicker']
            ])
            ->add('typeEvent', EntityType::class, options: [
                'label' => 'Choisir le type',
                'class' => TypeEvent::class,
                'choice_label' => 'libType',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('typeevent')
                        ->orderBy('typeevent.id', 'DESC');
                },
            ])
            ->add('description', TextareaType::class, options: [
                'label' => 'Choisir une description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'clientId' => 0
        ]);
    }
}
