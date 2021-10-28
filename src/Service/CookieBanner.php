<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class CookieBanner extends AbstractController {

    private string $message = "
        Noi e terze parti selezionate utilizziamo cookie o tecnologie simili come specificato nella cookie policy. 
        Puoi acconsentire all’utilizzo di tali tecnologie chiudendo questa informativa. 
        I Cookie sono costituiti da porzioni di codice installate all’interno del browser che assistono il Titolare nell’erogazione del servizio in base alle finalità descritte. 
        Alcune delle finalità di installazione dei Cookie potrebbero, inoltre, necessitare del consenso dell’Utente.
        ";

    private bool $cookie_consent = false;

    public function getMessage(): string {
        return $this->message;
    }

    public function cookieForm() {

        $cookie_form = $this->createFormBuilder([])
            ->add('acept', ButtonType::class, [
               'attr' => ['class' => 'save'] 
            ])
            ->add('no', ButtonType::class, [
                'attr' => ['class' => 'no']
            ])
            ->getForm();

        return $cookie_form->createView();

    }

}