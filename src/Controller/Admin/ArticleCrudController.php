<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('description'),
            TextField::new('url'),
            DateTimeField::new('date'),
            DateTimeField::new('update_at'),
            AssociationField::new('image')
            ->setFormTypeOptions([
                'by_reference' => true,
            ]),
            AssociationField::new('category')
            ->setFormTypeOptions([
                'by_reference' => true,
            ]),
            AssociationField::new('tags')
            ->setFormTypeOptions([
                'by_reference' => false,
            ]),
            BooleanField::new('genderOption'),
            CodeEditorField::new('content'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('title')
            ->add('date');
    }

    /**
     * Set all the content in DESC
     * order by their date
     */
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setDefaultSort([
                'date'  => 'DESC'
            ]);
    }

}
