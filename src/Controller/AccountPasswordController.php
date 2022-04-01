<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $EntityManager;

    public function __construct(EntityManagerInterface $EntityManager){
        $this->EntityManager = $EntityManager;
    }

    #[Route('/compte/modification-mot-de-passe', name: 'account_password')]               // il faut ajouter compte car dans la security la navigation est autorisé pour les route avec compte/

    public function index(Request $request, UserPasswordEncoderInterface $encoder) : Response
    {
        $notification = null;

        // Creation du User que l'on integre dans le formulaire
        $user = $this->getUser();                                                       // On recupere l'utilisateur courant en l'appelant
        $form = $this->createForm(ChangePasswordType::class, $user);                // Creation du formulaire en faisant appel à l'objet $user

        // Etre à l'écoute des ecritures formulaires
        $form->handleRequest($request);                                                         // Etre à l'écoute du remplissage du formulaire

        // Si c'est validé et soumis on change le mot de passe
        if($form->isSubmitted() && $form->isValid()){
            // Une methode pour comparer le mot de passe actuel avec le mot de passe en bdd
                $old_pwd = $form->get('old_password')->getData();                       // Recuperation de l'ancien password
                //dd($old_pwd);
                if($encoder->isPasswordValid($user, $old_pwd)){                     // Si l'ancien passe word inscrit egal à celui en bdd alors
                    // Recuperation du nouveau et encodage
                    $new_pwd = $form->get('new_password')->getData();                // Recuperation du nouveau password que l'user vient d'écrire
                    $password = $encoder->encodePassword($user, $new_pwd);          // On l'encrypte

                    // Definir le nouveau password
                    $user->setPassword($password);

                    // Envoi des données à la bdd
                    $this->EntityManager->persist($user);                                   // On prepare la data avant de l'envoyer (on la fige)
                    $this->EntityManager->flush();                                        //On envoie la data )à la base de donnée

                    $notification = 'Votre mot de passe est bien mis à jour';
                }
                else{
                    $notification = "Votre mot de passe n'est pas valide";
                }
        }

        // Renvoi la vue du formulaire
        return $this->render('account/password.html.twig',[
            'form'  => $form->createView(),                                             // On passe la vue en paramètre pour l'envoyer dans la vue
            'notification' => $notification
        ]);
    }
}
