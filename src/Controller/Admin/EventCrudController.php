<?php

namespace App\Controller\Admin;

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
                ->setFormTypeOption('choice_label', 'name')
                ->setFormTypeOption('query_builder', function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('animal')
                        ->innerJoin()
                        ->orderBy('espece.name', 'ASC');
                })
                ->formatValue(function ($value, Animal $entity) {
                    return $entity->getEspece()?->getName();
                }),
        ];
    }
}
