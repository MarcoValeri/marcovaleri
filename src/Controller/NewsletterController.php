<?php

namespace App\Controller;

use App\Entity\Newsletter;

use App\Form\NewsletterForm;
use App\Form\NewsletterSenderForm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class NewsletterController extends AbstractController {

    /**
     * @Route("/page/newsletter", name="app_newsletter")
     */
    public function registerNewsletter(Request $request, PersistenceManagerRegistry $doctrine) {

        $newsletter = new Newsletter();

        /**
         * Create a flag variable that allow to show
         * error on the template if the email
         * is already registered
         */
        $newsletterAlreadyRegistered = false;

        /**
         * Save the form into the $form_newsletter and
         * validate it
         */
        $form_newsletter = $this->createForm(NewsletterForm::class, $newsletter);
        $form_newsletter->handleRequest($request);

        if ($form_newsletter->isSubmitted()) {

            if ($form_newsletter->isValid()) {

                // EntityManager
                $em = $doctrine->getManager();
                $em->persist($newsletter);
                $em->flush();

                // Send email if new user has subscribed to the newsletter list
                $newUserName = $form_newsletter->getData()->getName();
                $newUserEmail = $form_newsletter->getData()->getEmail();
                $emailObj = "Grazie per esserti iscritto alla newsletter di MarcoValeri.net";
                $emailMsg = "Ciao " . $newUserName . ",\n\n";
                $emailMsg .= "Grazie per esserti iscritto alla mia newsletter.\n";
                $emailMsg .= "A presto.\n\n";
                $emailMsg .= "Marco Valeri";
                $wrapEmailMsg = wordwrap($emailMsg, 70);
                $emailHeaders = "From: Marco Valeri < info@marcovaleri.net >\n";
                
                mail($newUserEmail, $emailObj, $wrapEmailMsg. $emailHeaders);

                return $this->redirectToRoute('app_newsletter_confirm');
            } else if (!$form_newsletter->isValid()) {
                $newsletterAlreadyRegistered = true;
            }
        }

        return $this->render("pages/newsletter.html.twig", [
            'newsletterForm' => $form_newsletter->createView(),
            'newsletterAlreadyRegistered' => $newsletterAlreadyRegistered
        ]);

    }

    /**
     * @Route("/page/newsletter-confirm", name="app_newsletter_confirm")
     */
    public function newsletterConfirm(Request $request) {

        return $this->render("pages/newsletter-confirm.html.twig");

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

    /**
     * @Route("/admin/newsletter-sender", name="app_admin_newsletter_sender")
     */
    public function admineNewsletterSender(Request $request, PersistenceManagerRegistry $doctrine) {

        $emailSenderConfirm = "Email not send";

        /**
         * Save the form into the $form_newsletterSender and
         * validate it
         */
        $form_newsletterSender = $this->createForm(NewsletterSenderForm::class);
        $form_newsletterSender->handleRequest($request);

        if ($form_newsletterSender->isSubmitted() && $form_newsletterSender->isValid()) {

            // EntityManager
            $em = $doctrine->getManager();
            $emails = $em->getRepository(Newsletter::class)->findAll();

            // Get form data
            $formData = $form_newsletterSender->getData();
            $sendTestOrReal = $formData['emails'];
            $formSubject = $formData['subject'];
            $formContent = $formData['content'];
            $emailHeaders = "MIME-Version: 1.0\r\n";
            $emailHeaders .= "Content-type: text/html; charset=utf-8\r\n";
            $emailHeaders .= "From: Marco Valeri < info@marcovaleri.net >\n";

            if ($sendTestOrReal) {
                // Send email to reale users
                echo "Real users";
                foreach ($emails as $email) {
                    $userEmail = $email->getEmail();
                    mail($userEmail, $formSubject, $formContent, $emailHeaders);
                }
                $emailSenderConfirm = "Email sent to real users";
            } else {
                // Send email to test users
                echo "Test users";
                mail("info@marcovaleri.net, marcovaleri@hotmail.it", $formSubject, $formContent, $emailHeaders);
                $emailSenderConfirm = "Email sent to test users";
            }

        }

        return $this->render("admin/newsletter-sender.html.twig", [
            'newsletterSendeForm'   => $form_newsletterSender->createView(),
            'emailSenderConfirm'    => $emailSenderConfirm
        ]);

    }

}