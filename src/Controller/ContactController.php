<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Description of AccueilController
 *
 * @author Mc
 */
class ContactController extends AbstractController {
    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function index(Request $request, MailerInterface $mailer): Response {
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact); 
        $formContact->handleRequest($request);
        
        
        if ($formContact->isSubmitted() && $formContact->isValid()){
            //envoi du mail
            $this->envoiMail($mailer, $contact);
            $this->addFlash('sucess', 'message envoyé');
            return $this->redirectToRoute('contact');
        }
        
        return $this->render("pages/contact.html.twig",[
            'contact' => $contact,
            'formcontact' => $formContact->createView()
        ]);
        
    }
    /**
     * @param MailerInterface $mailer
     * @param Contact $contact
     */

    public function envoiMail(MailerInterface $mailer, Contact $contact)
    {
        $email = (new Email())
            ->From($contact->getEmail())
            ->To('contact@mesvoyages.fr')
            ->subject('Message du site de voyages')
            ->text('Sending emails is fun again!')
            ->html($this->renderView(
                    'pages/_email.html.twig', [
                        'contact' => $contact
                    ]
                ),
                'text/html'
            );
        $mailer->send($email);
    }
}