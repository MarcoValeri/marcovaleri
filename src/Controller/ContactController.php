<?php

namespace App\Controller;

use App\Form\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController {

    #[Route('/page/contatti', name: 'app_contact')]
    public function contact(Request $request) {

        /**
         * Save the form into the $form_contact and 
         * validate it
         */
        $form_contact = $this->createForm(Contact::class);

        $form_contact->handleRequest($request);

        if ($form_contact->isSubmitted() && $form_contact->isValid()) {

            $name = $form_contact->get('name')->getData();
            $surname = $form_contact->get('surname')->getData();
            $email = $form_contact->get('email')->getData();
            $message = $form_contact->get('message')->getData();

            $email_message = "Contatti da MarcoValeri.net \n";
            $email_message .= "\n";
            $email_message .= "Name: " . $name . "\n";
            $email_message .= "Surname: " . $surname . "\n";
            $email_message .= "Email: " . $email . "\n";
            $email_message .= "\n";
            $email_message .= "Message: \n";
            $email_message .= $message;

            $email_message = wordwrap($email_message, 100);

            mail("info@marcovaleri.net", "Contatti MarcoValeri.net", $email_message);

            return $this->redirectToRoute('app_contact_confirm');

        }

        return $this->render("pages/contact.html.twig", [
            'contactForm' => $form_contact->createView()
        ]);

    }

    #[Route('/page/contatti-conferma', name: 'app_contact_confirm')]
    public function contactConfirm() {

        return $this->render("pages/contact-confirm.html.twig");

    }

}