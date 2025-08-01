<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserController extends AbstractController {

    #[Route('/user-registration', name: 'app_user_registration')]
    public function registration(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine) {

        // Create form
        $regForm = $this->createFormBuilder()
        ->add('email', EmailType::class, [
            'label' => 'Email'
        ])
        ->add('role', ChoiceType::class, [
            'label' => 'Role',
            'choices' => [
                'ROLE_ADMIN' => 'ROLE_ADMIN'
            ]
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'first_options' => ['label' => 'Password'],
            'second_options' => ['label' => 'Password Repeat']
        ])
        ->add('register', SubmitType::class)
        ->getForm();

        // Save the data into the database
        $regForm->handleRequest($request);

        if ($regForm->isSubmitted()) {
            $input = $regForm->getData();

            $user = new User();
            $user->setEmail($input['email']);

            $user->setRoles([$input['role']]);

            $user->setPassword(
                $passwordHasher->hashPassword($user, $input['password'])
            );

            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            // redirect to the homepage after the login
            return $this->redirect($this->generateUrl('app_home'));

        }

        return $this->render('register_user/index.html.twig', [
            'regform' => $regForm->createView()
        ]);

    }
    
}
