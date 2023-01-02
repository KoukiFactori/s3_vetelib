<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $message = (new Email())
                ->from('contact@vetelib.fr')
                ->to('simon@simon511000.fr')
                ->subject('Vous avez reçu un message de la page contact')
                ->text(<<<TXT
                    Nom : {$contactFormData['lastname']}
                    Prénom : {$contactFormData['firstname']}
                    Adresse Mail : {$contactFormData['email']}
                    Message : {$contactFormData['message']}
                TXT)
            ;

            $mailer->send($message);

            return $this->redirectToRoute('app_contact');
        }

        return $this->renderForm('contact/index.html.twig', compact('form'));
    }
}
