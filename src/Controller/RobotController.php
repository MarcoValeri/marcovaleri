<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RobotController extends AbstractController {

    /**
     * @Route("/robots.txt", name="app_robot", defaults={"_format"="txt"})
     */
    public function robot() {
        return $this->render("seo/robots.html.twig");
    }

}