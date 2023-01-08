<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/',
                        'message' => 'Le prénom ne peut contenir que des lettres.',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/',
                        'message' => 'Le nom ne peut contenir que des lettres.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, ['empty_data' => ''])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Le numéro de téléphone ne peut contenir que des chiffres.',
                    ]),
                ],
            ])
            ->add('birthdate')
            ->add('city')
            ->add('zipcode', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{5}$/',
                        'message' => 'Le code postal doit être composé de 5 chiffres.',
                    ]),
                ],
            ])
            ->add('address')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
