<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("admin/users", name="app_admin_users")
     */
    public function showUsers(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render("admin/user.html.twig", [
            'users' => $users,
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="app_admin_user")
     */
    public function singleUser(UserRepository $userRepository, string $id)
    {
        $user = $userRepository->find($id);

        return $this->render("admin/user-data.html.twig", [
            'user' => $user,
        ]);
    }

}