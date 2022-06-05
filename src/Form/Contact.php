<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class Contact extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label' => 'Nome *',
                    'required' => true,
                    'constraints' => [
                            new Length([
                                'min' => 2,
                                'max' => 20,
                                'minMessage' => 'Nome è troppo corto, dovrebbe essere almeno di 2 caratteri',
                                'minMessage' => 'Nome è troppo lungo, dovrebbe essere di massimo 20 caratteri',
                            ]),
                            new Regex([
                                'pattern' => '/[a-zA-Z]/',
                                'message' => 'Errore: inserire solo lettere',
                            ]),
                        ],
                    ])
            ->add('surname', TextType::class,
                [
                    'label' => 'Cognome *',
                    'required' => true,
                    'constraints' => [
                            new Length([
                                'min' => 2,
                                'max' => 20,
                                'minMessage' => 'Cognome è troppo corto, dovrebbe essere almeno di 2 caratteri',
                                'maxMessage' => 'Cognome è lungo, dovrebbe essere di massimo 20 caratteri',
                            ]),
                            new Regex([
                                'pattern' => '/[a-zA-Z]/',
                                'message' => 'Errore: inserire solo lettere',
                            ]),
                        ],
                    ])
            ->add('email', EmailType::class,
                [
                    'label' => 'Email *',
                    'required' => true,
                    'invalid_message' => 'Errore: indirizzo email non valido',
                ])
            ->add('message', TextareaType::class,
                [
                    'label' => 'Messaggio *',
                    'required' => true,
                    'constraints' => [
                            new Length([
                                'min' => 10,
                                'max' => 500,
                                'minMessage' => 'Messaggio è troppo corto, dovrebbe essere di almeno 10 caratteri',
                                'maxMessage' => 'Messaggio è troppo lungo, dovrebbe essere di massimo 500 caratteri',
                            ]),
                        ],
                ])
            ->add('submit', SubmitType::class,
                [
                    'label' => 'Invia',
                ])
            ->getForm();
    }
}
