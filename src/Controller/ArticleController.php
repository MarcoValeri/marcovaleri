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

        return $this->render("articles/article.html.twig", [
            'articles' => $articles,
            'slug' => $slug
        ]);

    }

    #[Route('/articoli', name: 'app_articles')]
    public function blog(ArticleRepository $articleRepository, ManagerRegistry $doctrine)
    {
        $sqlQuery = '
            SELECT
                article.url,
                article.title,
                article.date,
                image.file_name,
                image.alternative_text,
                article.content
            FROM
                article
            INNER JOIN
                image ON article.image_id = image.id
            WHERE article.date < NOW()
            ORDER BY date DESC
            LIMIT 10
        ';
        $conn = $doctrine->getConnection();
        $stmt = $conn->prepare($sqlQuery);
        $result = $stmt->executeQuery();
        $articles = $result->fetchAllAssociative();
        
        return $this->render("articles/articles.html.twig", [
            'articles' => $articles,
        ]);
    }

}