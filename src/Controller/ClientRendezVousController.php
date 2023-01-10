<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;

class ClientRendezVousController extends AbstractController
{   
    private $em;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/mon_profil/event', name: 'app_client_rendez_vous')]
    public function index(EventRepository $er ,AnimalRepository $ar): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $user = $this->tokenStorage->getToken()->getUser();

        $allAppointment = $er->findAllEventByClient($user);

        return $this->render('client/client_rendez_vous/index.html.twig',['appointment' => $allAppointment]);
    }
}
