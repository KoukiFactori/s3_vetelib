<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('email', EmailType::class, ['empty_data' => '',])
            ->add('phone', TelType::class, ['empty_data' => '',])
            ->add('birthdate')
            ->add('city')
            ->add('zipcode', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{5}$/',
                        'message' => 'Le code postal doit être composé de 5 chiffres.'
                    ])
                ]
            ])
            ->add('address')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
