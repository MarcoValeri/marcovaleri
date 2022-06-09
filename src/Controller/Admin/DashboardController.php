<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Page;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Image;
use App\Entity\Newsletter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ArticleCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Marcovaleri');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Back to the website', 'fas fa-home', $this->generateUrl('app_home'));
        yield MenuItem::linktoDashboard('Dashboard', 'fas fa-solar-panel');
        yield MenuItem::linkToCrud('Users', 'fas fa-newspaper', User::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Pages', 'fas fa-file-alt', Page::class);
        yield MenuItem::linkToCrud('Categories', 'far fa-newspaper', Category::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tags', Tag::class);
        yield MenuItem::linkToCrud('Images', 'fas fa-images', Image::class);
        yield MenuItem::linkToCrud('Newsletter', 'fas fa-envelope', Newsletter::class);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    
}
