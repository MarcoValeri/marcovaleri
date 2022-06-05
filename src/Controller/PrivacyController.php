<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrivacyController extends AbstractController
{
    /**
     * @Route("/privacy/cookie-policy", name="app_cookie_policy")
     */
    public function cookiePolicy(): Response
    {
        return $this->render('privacy/cookie-policy.html.twig');
    }
}
