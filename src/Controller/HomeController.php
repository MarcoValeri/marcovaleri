<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    #[Route('/', name: 'app_home')]
    public function home(ArticleRepository $articleRepository) {

        $articles = $articleRepository->findAll();

        return $this->render("pages/home.html.twig", [
            'articles' => $articles,
        ]);
    }

}