<?php

namespace App\Controller;


use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    // Requete SQL find all grace à EntityManagerInterface
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

///////////////////////////////////////////////////////////////////////
///// Affichage de ous les produits////////////////////////////////////
/// ////////////////////////////////////////////////////////////////////
    #[Route('/nos-produits', name: 'products')]
    public function index(): Response
    {
        // Definition de la variable de recuperation des informations grace au manager
        // getRepository permet d'obtenir toutes les informations avec le nom de la classe
        $products = $this->entityManager->getRepository(Produits::class)->findAll();

        //Debug pour verifier les éléments que l'on récupère
        //dd($products);

        // Variable products pour afficher tous les produits coté twig
        return $this->render('product/index.html.twig',[
            'products' => $products
        ]);
    }
///////////////////////////////////////////////////////////////////////
///// Affichage d'une seule fiche produit ////////////////////////////////////
/// ////////////////////////////////////////////////////////////////////
    // Dans la route on lui cree un paramètre que l'on envoie dans la vue. En l'occurence slug
    #[Route('/produit/{slug}', name: 'product')]
    public function show($slug): Response
    {
        $product = $this->entityManager->getRepository(Produits::class)->findOneBySlug($slug);

        // Si il ne trouve pas le produit on redirige vers tous les produits
        if(!$product){
            return $this->redirectToRoute(products);
        }

        // On l'envoi vers un autre template
        return $this->render('product/show.html.twig',[
            'product' => $product
        ]);
    }
}
