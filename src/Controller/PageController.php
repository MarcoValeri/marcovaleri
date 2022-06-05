<?php

/**
 * This class has been created to give
 * routes and templates to the pages of
 * the web application, created manually or
 * by the admin section.
 */

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/page/{slug}", name="app_page")
     */
    public function page(PageRepository $pageRepository, string $slug): \Symfony\Component\HttpFoundation\Response
    {
        $pages = $pageRepository->findAll();

        return $this->render('pages/page.html.twig', [
            'pages' => $pages,
            'slug' => $slug,
        ]);
    }
}
