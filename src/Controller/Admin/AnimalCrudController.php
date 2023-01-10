<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnimalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
                ->setLabel('Nom'),
            DateField::new('birthdate')
                ->setLabel('Date de naissance'),
            AssociationField::new('espece')
                ->setLabel('Espèce')
                ->setFormTypeOption('choice_label', 'name')
                ->setFormTypeOption('query_builder', function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('espece')
                        ->orderBy('espece.name', 'ASC');
                })
                ->formatValue(function ($value, Animal $entity) {
                    return $entity->getEspece()?->getName();
                }),
            AssociationField::new('client')
                ->setLabel('Propriétaire')
                ->setFormTypeOption('choice_label', function($choice, $key, $value) {
                    return $choice->getLastName() . ' ' . $choice->getFirstName();
                })
                ->setFormTypeOption('query_builder', function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('client')
                        ->orderBy('client.lastname', 'ASC');
                })
                ->formatValue(function ($value, Animal $entity) {
                    $client = $entity->getClient();
                    return $client->getLastName() . ' ' . $client->getFirstName();
                }),
        ];
    }
}
