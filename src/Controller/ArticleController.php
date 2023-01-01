<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;

use App\Form\CommentForm;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class ArticleController extends AbstractController {

    #[Route('articoli/{slug}', name: 'app_article')]
    public function article(ArticleRepository $articleRepository, string $slug, Request $request, PersistenceManagerRegistry $doctrine) {

        /**
         * Save the comment form into $form_comment and
         * validate it
         */
        $formComment = $this->createForm(CommentForm::class);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            // Get form inputs
            $formCommentDateInput = $formComment->get('date')->getData();
            $formCommentNameInput = $formComment->get('name')->getData();
            $formCommentEmailInput = $formComment->get('email')->getData();
            $formCommentContentInput = $formComment->get('content')->getData();

            // Create new Comment
            $newComment = new Comment();
            $newComment->setDate($formCommentDateInput);
            $newComment->setName($formCommentNameInput);
            $newComment->setEmail($formCommentEmailInput);
            $newComment->setContent($formCommentContentInput);
            print_r($newComment);

            // Create Article and Comment Relationship
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

        // Save all the articles into a variable
        $articles = $articleRepository->findAll();

        return $this->render("pages/article.html.twig", [
            'articles' => $articles,
            'slug' => $slug,
            'formComment' => $formComment->createView()
        ]);

    }

    /**
     * @Route("/articoli", name="app_blog")
     */
    public function blog(ArticleRepository $articleRepository) {

        $articles = $articleRepository->findAll();

        return $this->render("pages/blog.html.twig", [
            'articles' => $articles,
        ]);

    }

}