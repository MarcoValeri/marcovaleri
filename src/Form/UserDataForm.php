<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('roles', ChoiceType::class,
            [
                'choices' => [
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_USER'  => 'ROLE_USER',
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN'
                ],
                'multiple'      => true,
            ])
            ->add('password', RepeatedType::class,
            [
                'type'              => PasswordType::class,
                'label'             => false,
                'options'           => ['attr' => ['class' => 'newsletter__input-email']],
                'required'          => true,
                'first_options' => ['label' => false, 'attr' => ['class' => 'newsletter__input-email', 'placeholder'   => 'Password *']],
                'second_options' => ['label' => false, 'attr' => ['class' => 'newsletter__input-email', 'placeholder'   => 'Repeat Password *']],
            ])
            ->add('submit', SubmitType::class,
            [
                'label' =>  'Modifica'
            ])
            ->getForm();
    }
}