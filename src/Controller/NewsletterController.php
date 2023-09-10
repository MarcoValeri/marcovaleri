<?php

namespace App\Controller;

use App\Entity\Newsletter;

use App\Form\NewsletterForm;
use App\Form\NewsletterSenderForm;
use App\Form\NewsletterUnsubscribeForm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class NewsletterController extends AbstractController {

    #[Route('/page/newsletter', name: 'app_newsletter')]
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
                $emailMsg = "<p style='font-size: 16px'>Ciao " . $newUserName . "</p><p>&nbsp;</p>";
                $emailMsg .= "<p style='font-size: 16px'>Grazie per esserti iscritto alla mia newsletter</p><p>&nbsp;</p>";
                $emailMsg .= "<p style='font-size: 16px'>A presto,</p>";
                $emailMsg .= "<p  style='font-size: 16px'>Marco Valeri</p>";
                $emailHeaders = "MIME-Version: 1.0\r\n";
                $emailHeaders .= "Content-type: text/html; charset=utf-8\r\n";
                $emailHeaders .= "From: Marco Valeri < info@marcovaleri.net >\n";
                
                mail($newUserEmail, $emailObj, $emailMsg, $emailHeaders);

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

    #[Route('/page/newsletter-confirm', name: 'app_newsletter_confirm')]
    public function newsletterConfirm()
    {
        return $this->render("pages/newsletter-confirm.html.twig");
    }

    #[Route('/page/newsletter-unsubscribe', name: 'app_newsletter_unsubscribe')]
    public function unsubscribeNewsletter(Request $request, PersistenceManagerRegistry $doctrine)
    {

        $formNewsletterUnsubscribe = $this->createForm(NewsletterUnsubscribeForm::class);
        $formNewsletterUnsubscribe->handleRequest($request);

        if ($formNewsletterUnsubscribe->isSubmitted() && $formNewsletterUnsubscribe->isValid()) {
            $userEmailUnsubscribe = $formNewsletterUnsubscribe->get('email')->getData();
            $emailObject = "MarcoValeriNew: unsubscribe email";
            $emailMessage = "<p style='font-size: 16px'>Richiesta di cancellazione dalla newsletter di MarcoValeri.net:</p>";
            $emailMessage .= "<p style='font-size: 16px'>Email: " . $userEmailUnsubscribe . "</p>";
            $emailHeaders = "MIME-Version: 1.0\r\n";
            $emailHeaders .= "Content-type: text/html; charset=utf-8\r\n";
            $emailHeaders .= "From: Marco Valeri < info@marcovaleri.net >\n";
            mail("info@marcovaleri.net", $emailObject, $emailMessage, $emailHeaders);

            // Create successful message with addFlash that save it to sessione and it is able once
            $this->addFlash('success-unsubscribe', "Richiesta inviata correttamente, la tua email verrà rimossa entro e non oltre le 48 ore");
        }

        return $this->render("pages/newsletter-unsubscribe.html.twig", [
            'formNewsletterUnsubscribe' => $formNewsletterUnsubscribe
        ]);

    }

    #[Route('/admin/newsletter-sender', name: 'app_admin_newsletter_sender')]
    public function admineNewsletterSender(Request $request, PersistenceManagerRegistry $doctrine, MailerInterface $mailer) {

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
            $formPreHeader = $formData['preheader'];
            $formContent = $formData['content'];

            // Create test data
            $testEmails = [
                'info@marcovaleri.net',
                'marcovaleri@hotmail.it'
            ];

            if ($sendTestOrReal) {
                // Send email to reale users
                echo "Real users";
                foreach ($emails as $newsletterEmail) {
                    $userEmail = $newsletterEmail->getEmail();
                    $userName = $newsletterEmail->getName();
                    $email = (new TemplatedEmail())
                        ->from('info@marcovaleri.net')
                        ->to($userEmail)
                        ->subject($formSubject)
                        ->htmlTemplate('emails/newsletter.html.twig')
                        ->context([
                            'userName'  => $userName,
                            'userEmail' => $userEmail,
                            'preHeader' => $formPreHeader,
                            'content'   => $formContent,
                        ]);
                    $mailer->send($email);
                }
                $emailSenderConfirm = "Email sent to real users";
            } else {
                // Send email to test users
                echo "Test users";
                foreach ($testEmails as $userEmail) {
                    $email = (new TemplatedEmail())
                        ->from('info@marcovaleri.net')
                        ->to($userEmail)
                        ->subject($formSubject)
                        ->htmlTemplate('emails/newsletter.html.twig')
                        ->context([
                            'userName'  => 'userName',
                            'userEmail' => $userEmail,
                            'preHeader' => $formPreHeader,
                            'content'   => $formContent,
                        ]);
                    $mailer->send($email);
                }
                
                $emailSenderConfirm = "Email sent to test users";
            }

        }

        return $this->render("admin/newsletter-sender.html.twig", [
            'newsletterSendeForm'   => $form_newsletterSender->createView(),
            'emailSenderConfirm'    => $emailSenderConfirm
        ]);

    }

}