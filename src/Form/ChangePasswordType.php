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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label'     => 'Mon email',
                'disabled'  => true              //On ne veut pas que l'utilisateur puisse changer l'email
            ])
//            ->add('roles')                // On ne veut pas que l'utilisateur change son rôle

            ->add('firstname', TextType::class, [
                'label'     => 'Mon prenom',
                'disabled' => true             //On ne veut pas que l'utilisateur puisse changer l'email
            ])
            ->add('lastname', TextType::class, [
                'label'     => 'Mon nom',
                'disabled' =>  true             //On ne veut pas que l'utilisateur puisse changer l'email
            ])
            ->add('old_password', PasswordType::class, [
                'label'     => 'Mon mot de passe actuel',
                'mapped'    => false,
                'attr'      =>  [
                    'placeholder'   =>  'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password',  RepeatedType::class, [
                'type'  => PasswordType::class,                         // correspond à un input Password
                'mapped'=> false,
                'invalid_message' => 'Les mots de passe et confirmation doivent être identiques.',    //Si le message est faux
                'label' => 'Mon mot de passe',
                'required' => 'true',                                   // Les 2 passwords necessaires
                'first_options' => [                                    // Le premier bloc password
                    'label' => 'Mon nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre nouveau mot de passe.'
                    ]
                ],
                'second_options' => [                                    // Le second bloc password
                    'label' => 'Confirmation de mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre mot de passe.'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
            'label' => "Mettre à jour"
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
