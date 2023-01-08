<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ClientAnimalsController extends AbstractController
{
    #[Route('/client/animals', name: 'app_client_animals')]
    public function index(AnimalRepository $ar , EventRepository $er): Response
    {
        $now = new \DateTime();
        //$this->denyAccessUnlessGranted('ROLE_CLIENT');

        //$clientId=$this->getUser()->Id;
        $animals=$ar->getAllAnimalsByClient(23);

        $appointments = [];

    foreach ($animals as $animal) 
    {
        $appointments[$animal->getId()] = $er->findEventByAnimal($animal);
    }

        return $this->render('client/client_animals/index.html.twig', ['animals' => $animals, 'now'=> $now ,'appointments' => $appointments,] );
    }
    
     #[Route("/client/animals/{id}",name: 'data_client_animals')]
    public function animalInformation(int $id ,AnimalRepository $ar , EventRepository $er ,SerializerInterface $ser)
    {

        //$user=$this->getUser();
        $animal = array_values(array_filter($ar->getAllAnimalsByclient(23), function($animal) use ($id) {
            return $animal->getId() === $id;
        }))[0];

        return new Response($ser->serialize($animal, 'json', [
            AbstractNormalizer::ATTRIBUTES => [
              'name',
              'birthdate',
              'espece' => ['name'],
              'events' => ['date', 'description', 'typeEvent' => ['libType']]
            ]
          ]));
    

    }
}
