<?php

namespace App\Controller\Admin;

use App\Entity\Produits;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProduitsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produits::class;
    }

    // Configuration des inputs pour la creation de nouveaux produits
    public function configureFields(string $pageName): iterable
    {
        return [
          TextField::new('name'),
            // Raccourcis d'adresse en ciblant le nome de l'adresse
          SlugField::new('slug')->setTargetFieldName('name'),
            // Adresse ou l'on upload les photo // puis la manière dont on encode le nom des fichiers images // N'est pas requis
          ImageField::new('illustration')
              ->setBasePath('uploads/')
              ->setUploadDir('public/uploads/')
              ->setUploadedFileNamePattern('[randomhash].[extension]')
              ->setRequired(false),
          TextField::new('subtitle'),
          TextareaField::new('description'),
            // Le prix des produits en euro
          MoneyField::new('price')->setCurrency('EUR'),
          AssociationField::new('category')
        ];
    }

}
