<?php
/**
 * Created this controller for handling the
 * 404 error to the sub directory like
 * devwithit/guide/article-not-found
 * 
 * However, this controller is not part of Symfony
 * error bundle
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error/page-not-found', name: 'app_error404')]
    public function error404()
    {
        return $this->render('errors/error404.html.twig');
    }
}