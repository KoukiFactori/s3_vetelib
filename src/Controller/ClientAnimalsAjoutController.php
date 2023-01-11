<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Espece;
use App\Form\AddAnimalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ClientAnimalsAjoutController extends AbstractController
{
    
    private $em;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/mon_profil/animal/add', name: 'app_client_animals_ajout')]
    public function index(Request $request): Response
    {
        $user = $this->tokenStorage->getToken()->getUser();
        
        $form = $this->createForm(AddAnimalType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Création d'un animal à partir des informations données dans le formulaire
            $animal = new Animal();
            $animal->setName($form['name']->getData());
            $animal->setBirthdate($form['birthdate']->getData());

            $especeId = $form['espece']->getData();
            $espece = $this->em->getRepository(Espece::class)->find($especeId);
            $animal->setEspece($espece);

            $animal->setClient($user);

            
            $this->em->persist($animal);
            $this->em->flush();

            return $this->redirectToRoute('app_client_animals');
        }

        return $this->render('client/client_animals/client_animals_ajout/index.html.twig', [
            'form' => $form->createView(), 'controller_name' => 'ClientAnimalsAjoutController',
        ]);
    }
}
