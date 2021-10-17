<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController {

    /**
     * @Route("/{slug}", name="app_article")
     */
    public function article(ArticleRepository $articleRepository, string $slug) {

        $articles = $articleRepository->findAll();

        return $this->render("pages/article.html.twig", [
            'articles' => $articles,
            'slug' => $slug
        ]);

    }

}