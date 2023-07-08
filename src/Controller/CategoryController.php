<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('categoria/{slug}/pagina_{pageNumber}', name: 'app_category')]
    public function category(ArticleRepository $articleRepository, ManagerRegistry $doctrine, string $slug, string $pageNumber)
    {
        // $slug = "esperienze";

        $fromArticleNumber = $pageNumber * 10;
        $sqlQuery = "
            SELECT
                article.url,
                article.title,
                article.date,
                image.file_name,
                image.alternative_text,
                article.content,
                category.name,
                category.url
            FROM
                article
            INNER JOIN
                image ON article.image_id = image.id
            INNER JOIN
                category ON article.category_id = category.id
            WHERE article.date < NOW() AND category.url = '{$slug}'
            ORDER BY date DESC
            LIMIT {$fromArticleNumber}, 10
        ";

        $conn = $doctrine->getConnection();
        $stmt = $conn->prepare($sqlQuery);
        $result = $stmt->executeQuery();
        $articles = $result->fetchAllAssociative();
        // dd($articles);

        if (count($articles) > 0) {
            return $this->render("categories/category.html.twig", [
                'articles'      => $articles,
                'slug'          => $slug,
                'pageNumber'    => $pageNumber
            ]);
        } else {
            return $this->redirectToRoute('app_error404');
        }

    }
}