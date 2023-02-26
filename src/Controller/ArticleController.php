<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController {

    #[Route('articoli/{slug}', name: 'app_article')]
    public function article(ArticleRepository $articleRepository, string $slug) {

        $articles = $articleRepository->findAll();

        return $this->render("pages/article.html.twig", [
            'articles' => $articles,
            'slug' => $slug
        ]);

    }

    #[Route('/articoli', name: 'app_blog')]
    public function blog(ArticleRepository $articleRepository) {

        $articles = $articleRepository->findAll();

        return $this->render("pages/blog.html.twig", [
            'articles' => $articles,
        ]);

    }

}