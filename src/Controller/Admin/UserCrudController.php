<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[IsGranted('ROLE_ADMIN')]
class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('roles')
                ->setLabel('Type')
                ->allowMultipleChoices()
                ->renderExpanded(true)
                ->setChoices([
                    'Client' => 'ROLE_CLIENT',
                    'Vétérinaire' => 'ROLE_VETERINAIRE'
                ]),
            TextField::new('email'),
            TextField::new('firstname')
                ->setLabel('Prénom'),
            TextField::new('lastname')
                ->setLabel('Nom'),
            TextField::new('phone')
                ->setLabel('Numéro de Téléphone')
                ->setRequired(false),
            DateField::new('birthdate')
                ->setLabel('Date de naissance'),
            TextField::new('city')
                ->setLabel('Ville'),
            TextField::new('zipcode')
                ->setLabel('Code Postal'),
            TextField::new('address')
                ->setLabel('Addresse'),
            TextField::new('password')
                ->setFormType(PasswordType::class)
                ->onlyOnForms()
                ->setFormTypeOptions([
                    'required' => false,
                    'empty_data' => '',
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ]),
        ];
    }

    private function setUserPassword($entityInstance): void
    {
        $password = $this->getContext()->getRequest()->get('User')['password'];

        if($password != "") {
            $entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $password));
        }
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);

        parent::persistEntity($entityManager, $entityInstance);
    }

}
