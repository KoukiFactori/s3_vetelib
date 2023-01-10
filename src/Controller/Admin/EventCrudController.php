<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Entity\Event;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('description')
                ->setLabel('Description'),
            DateTimeField::new('date')
                ->setLabel('Horraire'),
            AssociationField::new('animal')
                ->setLabel('Animal')
                ->setFormTypeOption('choice_label', function($choice, $key, $value) {
                    return (
                        $choice->getClient()->getLastName()
                        . ' '
                        . $choice->getClient()->getFirstName()
                        . ' - '
                        . $choice->getName()
                    );
                })
                ->setFormTypeOption('query_builder', function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('animal')
                        ->addSelect('client')
                        ->innerJoin('animal.client', 'client')
                        ->orderBy('client.lastname', 'ASC')
                        ->addOrderBy('client.firstname', 'ASC');
                })
                ->formatValue(function ($value, Event $entity) {
                    return $entity->getAnimal()->getName();
                }),
            AssociationField::new('animal')
                ->setLabel('Client')
                ->hideOnForm()
                ->setVirtual(true)
                ->setFormTypeOption('choice_label', function($choice, $key, $value) {
                    return (
                        $choice->getClient()->getLastName()
                        . ' '
                        . $choice->getClient()->getFirstName()
                    );
                })
                ->setFormTypeOption('query_builder', function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('animal')
                        ->addSelect('client')
                        ->innerJoin('animal.client', 'client')
                        ->orderBy('client.lastname', 'ASC')
                        ->addOrderBy('client.firstname', 'ASC');
                })
                ->formatValue(function ($value, Event $entity) {
                    return (
                        $entity->getAnimal()->getClient()->getLastname()
                        . ' '
                        . $entity->getAnimal()->getClient()->getFirstname()
                    );
                }),
            AssociationField::new('typeEvent')
                ->setLabel('Type')
                ->setFormTypeOption('choice_label', 'libtype')
                ->setFormTypeOption('query_builder', function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('typeEvent')
                        ->orderBy('typeEvent.libType', 'ASC');
                })
                ->formatValue(function ($value, Event $entity) {
                    return $entity->getTypeEvent()->getLibType();
                }),
            AssociationField::new('veterinaire')
                ->setLabel('Vétérinaire')
                ->setFormTypeOption('choice_label', function($choice, $key, $value) {
                    return (
                        $choice->getLastName()
                        . ' '
                        . $choice->getFirstName()
                    );
                })
                ->setFormTypeOption('query_builder', function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('veterinaire')
                        ->orderBy('veterinaire.lastname', 'ASC')
                        ->addOrderBy('veterinaire.firstname', 'ASC');
                })
                ->formatValue(function ($value, Event $entity) {
                    return (
                        $entity->getVeterinaire()->getLastname()
                        . ' '
                        . $entity->getVeterinaire()->getFirstname()
                    );
                }),
        ];
    }
}
