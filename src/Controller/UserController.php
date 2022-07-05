<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use App\Form\UserDataForm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("admin/users", name="app_admin_users")
     */
    public function showUsers(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render("admin/users.html.twig", [
            'users' => $users,
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="app_admin_user")
     */
    public function singleUser(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository, string $id, ManagerRegistry $doctrine)
    {
        $userDataForm = $this->createForm(UserDataForm::class);
        $userDataForm->handleRequest($request);

        if ($userDataForm->isSubmitted() && $userDataForm->isValid()) {

            $inputUserDataForm = $userDataForm->getData();

            // dd($inputUserDataForm);

            $em = $doctrine->getManager();
            $user = $em->getRepository(User::class)->find($id);
            $user->setEmail($inputUserDataForm['email']);
            $user->setPassword(
                $passwordHasher->hashPassword($user, $inputUserDataForm['password'])
            );
            $user->setRoles($inputUserDataForm['roles']);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('app_login'));

        }

        $user = $userRepository->find($id);

        return $this->render("admin/user-data.html.twig", [
            'user' => $user,
            'userDataForm' => $userDataForm->createView()
        ]);
    }

}