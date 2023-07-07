<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Form\CommentForm;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController {

    #[Route('articoli/{slug}', name: 'app_article')]
    public function article(ArticleRepository $articleRepository, Request $request, ManagerRegistry $doctrine, string $slug)
    {

        /**
         * Save form CommentForm into the
         * $formComment variable
         * and
         * validate it
         */
        $formComment = $this->createForm(CommentForm::class);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            // Get the form inputs
            $formCommentArticleUrlInput = $formComment->get('articleUrl')->getData();
            $formCommentDateInput = $formComment->get('date')->getData();
            $formCommentNameInput = $formComment->get('name')->getData();
            $formCommentEmailInput = $formComment->get('email')->getData();
            $formCommentContentInput = $formComment->get('content')->getData();
    
            // Create new comment
            $newComment = new Comment();
            $newComment->setArticleUrl($slug);
            $newComment->setDate($formCommentDateInput);
            $newComment->setName($formCommentNameInput);
            $newComment->setEmail($formCommentEmailInput);
            $newComment->setContent($formCommentContentInput);
    
            // Create Article and Comment relationship
            $em = $doctrine->getManager();
            $getCurrentArticle = $em->getRepository(Article::class)->findOneBy(['url' => $slug]);

            $getCurrentArticle->addComment($newComment);
            $em->persist($newComment);
            $em->flush();

            // Create successful message with addFlash that save it to sessione and it is able once
            $this->addFlash('success', 'Commento inviato correttamente ed in fase di approvazione');

            // Redirect for cleaning form data
            return $this->redirectToRoute('app_article', ['slug' => $slug]);
        }

        $article = $articleRepository->findOneBy(['url' => $slug]);
        $articleDate = $article->getDate()->format('Y-m-d h:i:s');
        $dateNow = date('Y-m-d h:i:s');

        if ($article && $articleDate < $dateNow) {
            return $this->render("articles/article.html.twig", [
                'article'       => $article,
                'slug'          => $slug,
                'formComment'   => $formComment->createView()
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