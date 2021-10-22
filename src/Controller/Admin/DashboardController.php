<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Page;
use App\Entity\Category;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Marcovaleri');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToRoute('Back to the website', 'fas fa-home', 'app_page_home');
        yield MenuItem::linktoDashboard('Dashboard', 'fas fa-solar-panel');
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Pages', 'fas fa-file-alt', Page::class);
        yield MenuItem::linkToCrud('Categories', 'far fa-newspaper', Category::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tags', Tag::class);
    }
}
