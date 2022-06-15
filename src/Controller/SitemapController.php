<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController {

    /**
     * @Route("/sitemap.xml", name="app_sitemap", defaults={"_format"="xml"})
     */
    public function sitemap(ArticleRepository $articleRepository) {

        $articles = $articleRepository->findAll();

        return $this->render("seo/sitemap.html.twig", [
            'articles' => $articles
        ]);

    }

}