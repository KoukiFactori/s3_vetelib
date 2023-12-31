<?php

namespace App\Controller\Admin;

use App\Entity\Espece;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class EspeceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Espece::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
                ->setLabel('Nom'),
        ];
    }
}
