<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Espece;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddAnimalType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $especes = $this->em->getRepository(Espece::class)->findAll();
        $choices = [];

        foreach ($especes as $espece) {
            $choices[$espece->getName()] = $espece->getId();
        }

        $builder
            ->add('name')
            ->add('birthdate')
            ->add('espece', ChoiceType::class, [
                'choices' => $choices,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
