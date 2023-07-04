<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController {

    #[Route('articoli/{slug}', name: 'app_article')]
    public function article(ArticleRepository $articleRepository, string $slug)
    {
        $article = $articleRepository->findOneBy(['url' => $slug]);
        $articleDate = $article->getDate()->format('Y-m-d h:i:s');
        $dateNow = date('Y-m-d h:i:s');

        if ($article && $articleDate < $dateNow) {
            return $this->render("articles/article.html.twig", [
                'article'   => $article,
                'slug'      => $slug
            ]);
        } else {
            return $this->redirectToRoute('app_error404');
        }

    }

    #[Route('/articoli-archivio/pagina_{pageNumber}', name: 'app_articles_archive')]
    public function articoliArchivio(ArticleRepository $articleRepository, ManagerRegistry $doctrine, string $pageNumber)
    {
        $fromArticleNumber = $pageNumber * 10;
        $sqlQuery = "
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
            LIMIT {$fromArticleNumber}, 10
        ";
        $conn = $doctrine->getConnection();
        $stmt = $conn->prepare($sqlQuery);
        $result = $stmt->executeQuery();
        $articles = $result->fetchAllAssociative();
        
        if (count($articles) > 0) {
            return $this->render("articles/articles-archive.html.twig", [
                'articles'      => $articles,
                'pageNumber'    => $pageNumber
            ]);
        } else {
            return $this->redirectToRoute('app_error404');
        }
    }

}