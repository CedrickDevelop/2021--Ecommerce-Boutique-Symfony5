<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////  Creation du formulaire sur la page de membre  ////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('firstname', TextType::class, [           // correspond à un input Texte
                'label' => 'Votre prenom',
            // Les contraintes permettent d'indiquer les conditions de validité dans le formulaire.Nombre exacte, minimum, maximum
                'constraints' => new Length(5, 2, 30),
            // Les attributs sont les options du input
                'attr'  => [
                    'placeholder' => 'Veuillez saisir votre prenom'
                ]
            ])

            ->add('lastname',  TextType::class, [           // correspond à un input Texte
                'label' => 'Votre nom',
                'constraints' => new Length(5, 2, 30),
                'attr'  => [
                    'placeholder' => 'Votre saisir votre nom'
                ]
            ])

            ->add('email',  EmailType::class, [             // correspond à un input Email
                'label' => 'Votre email',
                'constraints' => new Length(10, 6, 60),
                'attr'  => [
                    'placeholder' => 'Votre email'
                ]
            ])

//            ->add('roles')     // On ne veut pas que la personne choisisse son rôle

                // Un peu lourd comme process, on met plutot repeatedType au password
//            ->add('password_confirm',  PasswordType::class, [
//                'label' => 'Confirmez votre mot de passe',
//                'mapped'=> false,
//                'attr'  => [
//                    'placeholder' => 'Confirmez votre mot de passe'
//                ]
//            ])

            ->add('password',  RepeatedType::class, [
                'type'  => PasswordType::class,                         // correspond à un input Password
                'invalid_message' => 'Les mots de passe et confirmation doivent être identiques.',    //Si le message est faux
                'label' => 'Votre ot de passe',
                'required' => 'true',                                   // Les 2 passwords necessaires
                'first_options' => [                                    // Le premier bloc password
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe.'
                    ]
                ],
                'second_options' => [                                    // Le second bloc password
                    'label' => 'Mot de passe confirmation',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre confirmation mot de passe.'
                    ]
                ],
                'attr'  => [
                    'placeholder' => 'Saisissez votre mot de passe'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
