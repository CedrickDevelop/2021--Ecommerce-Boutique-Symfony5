<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Produits;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La Boutique Francaise');
    }
    //////////////////////////////////////////////////////////////////////
    //Configuration du menu à gauche /////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    public function configureMenuItems(): iterable
    {
        // L'onglet menu
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // L'onglet utilisateur
        // Label : le nom
        // icon : aller voir sur font awesome
        // Entity : relier l'entité avec la classe correspondante
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Products', 'fa fa-tag', Produits::class);
    }
}
