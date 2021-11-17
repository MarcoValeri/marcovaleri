<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            // TextField::new('title'),
            // TextEditorField::new('description'),
            
            TextField::new('title'),
            TextField::new('description'),
            TextField::new('url'),
            DateTimeField::new('date'),
            DateTimeField::new('update_at'),
            TextField::new('image'),
            TextField::new('comments'),
            TextEditorField::new('content'),
            AssociationField::new('category')
                ->setFormTypeOptions([
                    'by_reference' => true,
                ]),
            AssociationField::new('tags')
                ->setFormTypeOptions([
                    'by_reference' => false,
                ]),
        ];
    }

}
