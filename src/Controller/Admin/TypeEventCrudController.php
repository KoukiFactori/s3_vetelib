<?php

namespace App\Controller\Admin;

use App\Entity\TypeEvent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class TypeEventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeEvent::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libType')
                ->setLabel('Libélé')
        ];
    }
}
