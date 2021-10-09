<?php

namespace App\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController {

    /**
     * @Route("/")
     */
    public function home() {
        return $this->render("pages/home.html.twig");
    }

    /**
     * @Route("/page/{slug}", name="app_page")
     */
    public function page(PageRepository $pageRepository, string $slug) {

        $pages = $pageRepository->findAll();

        return $this->render("page/page.html.twig", [
            'pages' => $pages,
            'slug' => $slug
        ]);

    }

}