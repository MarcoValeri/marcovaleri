<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewsletterUnsubscribeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,
            [
                'label'         => "Inserisci l'indirizzo email che vuoi cancellare",
                'attr'          => ['placeholder'   => 'Email *'],
            ])
            ->add('unsubscribe', SubmitType::class,
            [
                'label' => 'Unsubscribe'
            ])
            ->getForm();
    }
}