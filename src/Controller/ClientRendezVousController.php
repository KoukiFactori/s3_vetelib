<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

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

        $allAppointment = $er->getAllEventByClient($user);

        return $this->render('client/client_rendez_vous/index.html.twig',['appointments' => $allAppointment]);
    }
    #[Route('/mon_profil/rdv/{id}', name: 'data_client_rdv')]
    public function animalInformation(int $id, EventRepository $er, SerializerInterface $ser)
    {
        // $this->denyAccessUnlessGranted('ROLE_CLIENT');

        // $user=$this->getUser();
        $appointment = array_values(array_filter($er->getAllEventByClient(23), function ($animal) use ($id) {
            return $animal->getId() === $id;
        }))[0];

        return new Response($ser->serialize($appointment, 'json', [
            AbstractNormalizer::ATTRIBUTES => [
              'name',
              'id',
              'birthdate',
              'espece' => ['name'],
              'events' => ['date', 'description', 'typeEvent' => ['libType']],
            ],
          ]));
    }
}
