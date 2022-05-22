<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewsletterSenderForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('emails', ChoiceType::class, [
                'choices'   => [
                    'Test'  => false,
                    'Real'  => true
                ],
            ])
            ->add('subject', TextType::class)
            ->add('content', TextareaType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Invia'
            ])
            ->getForm();
    }

}