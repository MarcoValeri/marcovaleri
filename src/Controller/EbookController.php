<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EbookController extends AbstractController
{
    #[Route('/ebook/vivere-a-londra', name: 'app_ebook_vivere_a_londra')]
    public function ebookVivereALondra() {
        return $this->render("ebooks/vivere-a-londra.html.twig");
    }
}