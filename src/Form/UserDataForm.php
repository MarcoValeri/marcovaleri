<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserDataForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,
            [
                'label'             => false,
                'attr'              => ['placeholder'   => 'Email *'],
                'required'          => true,
                'invalid_message'   => 'Errore: indirizzo email non valido'
            ])
            ->add('password', RepeatedType::class,
            [
                'type'              => PasswordType::class,
                'label'             => false,
                'required'          => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Password Repeat']
            ])
            ->add('submit', SubmitType::class,
            [
                'label' =>  'Modifica'
            ])
            ->getForm();
    }
}