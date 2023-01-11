<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ClientAnimalsController extends AbstractController
{
    private $em;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/mon_profil/animal', name: 'app_client_animals')]
    public function index(AnimalRepository $ar, EventRepository $er): Response
    {
        $now = new \DateTime();
        $this->denyAccessUnlessGranted('ROLE_CLIENT');

        $user = $this->tokenStorage->getToken()->getUser();
        $userId = $user->getId();

        $animals = $ar->getAllAnimalsByClient($userId);

        $appointments = [];

        foreach ($animals as $animal) {
            $appointments[$animal->getId()] = $er->findEventByAnimal($animal);
        }

        return $this->render('client/client_animals/index.html.twig', ['animals' => $animals, 'now' => $now, 'appointments' => $appointments]);
    }

     #[Route('/mon_profil/animal/{id}', name: 'data_client_animals')]
    public function animalInformation(int $id, AnimalRepository $ar, EventRepository $er, SerializerInterface $ser)
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');

        $userId = $this->getUser()->getId();
        $animal = array_values(array_filter($ar->getAllAnimalsByclient($userId), function ($animal) use ($id) {
            return $animal->getId() === $id;
        }))[0];

        return new Response($ser->serialize($animal, 'json', [
            AbstractNormalizer::ATTRIBUTES => [
              'name',
              'id',
              'birthdate',
              'espece' => ['name'],
              'events' => ['date', 'description', 'typeEvent' => ['libType']],
            ],
          ]));
    }

    #[Route('/mon_profil/animal/{id}/delete', name: 'data_client_animals_delete')]
    public function deleteAnimal(int $id, AnimalRepository $ar, ManagerRegistry $doctrine, EventRepository $er)
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');

        $user = $this->getUser();
        $userId = $user->getId();
        $animal = array_values(array_filter($ar->getAllAnimalsByclient($userId), function ($animal) use ($id) {
            return $animal->getId() == $id;
        }))[0];
        $appointments = $er->findEventByAnimal($animal);
        foreach ($appointments as $appointment) {
            $em = $doctrine->getManager();
            $em->remove($appointment);
            $em->flush();
        }
        $em = $doctrine->getManager();
        $em->remove($animal);
        $em->flush();

        return $this->redirectToRoute('app_client_animals');
    }
}
