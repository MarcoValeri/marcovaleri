<?php

namespace App\Controller;

use App\Entity\Newsletter;

use App\Form\NewsletterForm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class NewsletterController extends AbstractController {

    /**
     * @Route("/page/newsletter", name="app_newsletter")
     */
    public function registerNewsletter(Request $request, PersistenceManagerRegistry $doctrine) {

        $newsletter = new Newsletter();

        /**
         * Save the form into the $form_newsletter and
         * validate it
         */
        $form_newsletter = $this->createForm(NewsletterForm::class, $newsletter);
        $form_newsletter->handleRequest($request);

        if ($form_newsletter->isSubmitted() && $form_newsletter->isValid()) {

            // EntityManager
            $em = $doctrine->getManager();
            $em->persist($newsletter);
            $em->flush();

            // Send email if new user has subscribed to the newsletter list
            $newUserName = $form_newsletter->getData()->getName();
            $newUserEmail = $form_newsletter->getData()->getEmail();
            $emailObj = "Grazie per esserti iscritto alla newsletter di MarcoValeri.net";
            $emailMsg = "Ciao " . $newUserName;
            $emailMsg .= "Grazie per esserti iscritto alla mia newsletter";
            $wrapEmailMsg = wordwrap($emailMsg, 70);
            
            mail($newUserEmail, $emailObj, $wrapEmailMsg);

            return $this->redirect('app_contact_confirm');
        }

        return $this->render("pages/newsletter.html.twig", [
            'newsletterForm' => $form_newsletter->createView()
        ]);

    }

    /**
     * @Route("/page/newsletter-unsubscribe/{email}/{checkId}", name="app_newsletter_unsubscribe")
     */
    public function unsubscribeNewsletter(PersistenceManagerRegistry $doctrine, string $email, string $checkId) {

        // Security check id
        $securityCheckId = "123456789";

        // EntityManager
        $em = $doctrine->getManager();
        $unsubscribeEmail = $em->getRepository(Newsletter::class)->findOneBy(['email' => $email]);

        if ($unsubscribeEmail && $checkId === $securityCheckId) {
            $em->remove($unsubscribeEmail);
            $em->flush();
        }

        return $this->render("pages/newsletter-unsubscribe.html.twig", [
            'unsubscribeEmail'  => $unsubscribeEmail,
            'email'             => $email,
        ]);

    }

}