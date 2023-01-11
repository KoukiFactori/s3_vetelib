<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Animal;
use App\Entity\Client;
use App\Entity\Espece;
use App\Entity\Event;
use App\Entity\TypeEvent;
use App\Entity\User;
use App\Entity\Veterinaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sae3 01');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Administrateurs', 'fa fa-user', Admin::class);
        yield MenuItem::linkToCrud('Vétérinaires', 'fa fa-user', Veterinaire::class);
        yield MenuItem::linkToCrud('Clients', 'fa fa-user', Client::class);
        yield MenuItem::linkToCrud('Rendez-vous', 'fa fa-calendar-days', Event::class);
        yield MenuItem::linkToCrud('Types de RDV', 'fa fa-list', TypeEvent::class);
        yield MenuItem::linkToCrud('Animaux', 'fa fa-cat', Animal::class);
        yield MenuItem::linkToCrud('Espèces', 'fa fa-hippo', Espece::class);
    }
}
