<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class RegisterController extends AbstractController
{

    private $EntityManager;

    public function __construct(EntityManagerInterface $EntityManager){
        $this->EntityManager = $EntityManager;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////  Instancie le USER et CREE Le FORMULAIRE DANS LA VUE ////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response //$encoder = On ajoute de la sécurité dans l'encodage du mot de passe
    {
        // Creation du formulaire
        $user = new User();                                              // Creation du User
        $form = $this->createForm(RegisterType::class,  $user);     // Creation formulaire inscription avec pour model register type et comme variable le user

        // Etre à l'écoute des données formulaires
        $form -> handleRequest($request);                                // Injection de dépendance dans le $request pour etre à l'écoute du formulaire

        if ($form->isSubmitted() && $form->isValid()){                   // si notre formulaire est valide
            $user = $form->getData();                                    // Injecter dans le user toutes les données inscrites dans les inputs
        // Si les infos sont bonnes envoyer les données à la bdd
            //$doctrine = $this->getDoctrine()->getManager();              // Appel de la classe doctrine manager
            // Voir le constructeur Entity mananger qui remplace doctrine

        // Encodage du mot de passe
            $password = $encoder->encodePassword($user,$user->getPassword()) ;     // On encode le password de $user. $user pour le password brut, getpassword pour le mot de passe encodé
            $user->setPassword($password);                                          // On renvoi le password à l'user pour l'injecter en bdd
            //dd($password);
        // Envoi des données à la bdd
            $this->EntityManager->persist($user);                                   // On prepare la data avant de l'envoyer (on la fige)
            $this->EntityManager->flush();                                        //On envoie la data )à la base de donnée

            //dd($user); ----> correspond à un var_dump die. Donne des infos sur la variable puis arreter le script

        }

        return $this->render('register/index.html.twig', [          // Creation de la vue formulaire inscription
            'form' => $form->createView()
        ]);
    }
}
