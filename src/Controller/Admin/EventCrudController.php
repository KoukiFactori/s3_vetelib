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
                        $choice->client->getLastName()
                        . ' '
                        . $choice->client->getFirstName()
                    )
                })
                ->setFormTypeOption('query_builder', function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('animal')
                        ->addSelect('client')
                        ->innerJoin('animal.client', 'client')
                        ->orderBy('animal.name', 'ASC');
                })
                ->formatValue(function ($value, Event $entity) {
                    return $entity->getAnimal()->getName();
                }),
        ];
    }
}
