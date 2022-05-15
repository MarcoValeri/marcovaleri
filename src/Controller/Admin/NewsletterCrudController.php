<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NewsletterCrudController extends AbstractCrudController {

    public static function getEntityFqcn(): string {
        return Newsletter::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('email'),
            DateField::new('date'),
        ];
    }

}