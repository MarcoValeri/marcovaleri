<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class CommentForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('date', HiddenType::class, [
                'data' => date('d/m/Y')
            ])
            ->add('name', TextType::class,
            [
                'label'         => false,
                'attr'          => ['placeholder'   => 'Nome *'],
                'required'      => true,
                'constraints'      =>
                [
                    new Length([
                        'min'           => 2,
                        'max'           => 70,
                        'minMessage'    => 'Nome è troppo corto, dovrebbe essere almeno di 2 caratteri',
                        'maxMessage'    => 'Nome è troppo lungo, dovrebbe essere massimo di 70 caratteri'
                    ]),
                    new Regex([
                        'pattern'       => '/[a-z-Z]/',
                        'message'       => 'Errore: inserire solo lettere'
                    ])
                ]
            ])
            ->add('email', EmailType::class,
            [
                'label'             => false,
                'attr'              => ['placeholder'   => 'Email *'],
                'required'          => true,
                'invalid_message'   => 'Errore: indirizzo email non valido'
            ])
            ->add('content', TextareaType::class,
            [
                'label' => false,
                'required' => true,
                'constraints' =>
                    [
                        new Length([
                            'min' => 10,
                            'minMessage' => 'Commento è troppo corto, dovrebbe essere di almeno 10 caratteri',
                        ])
                    ],
                'attr' => ['placeholder' => 'Commento *']
            ])
            ->add('privacy', CheckboxType::class, [
                'label'     => 'Accetto la privacy policy',
                'required'  => true,
            ])
            ->add('submit', SubmitType::class,
            [
                'label' =>  'Commenta'
            ])
            ->getForm();
    }

}