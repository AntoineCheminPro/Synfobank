<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => "Veuillez renseigner votre adresse email"],
                'label' => "Votre email :"
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'attr' => [ 'placeholder' => "Veuillez renseigner votre mot de passe"],
                'mapped' => false,
                'label' => 'Votre mot de passe :',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un mot de passe",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir {{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('firstname', TextType::class,  [
                'attr' => ['placeholder' => "Veuillez renseigner votre nom"],
                'label' => 'Votre nom :',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer votre nom",
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit contenir {{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('lastname', TextType::class,  [
                'attr' => ['placeholder' => "Veuillez renseigner votre prénom"],
                'label' => 'Votre prénom :',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un prénom",
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit contenir {{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),

                ],
            ])

            ->add('adress', TextType::class,  [
                'attr' => ['placeholder' => "Veuillez renseigner votre adresse"],
                'label' => 'Votre adresse :',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer une adresse",
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre adresse doit contenir {{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('city_code',TextType::class,  [
                'attr' => ['placeholder' => "Veuillez renseigner votre code postal"],
                'label' => 'Votre code postal :',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un code postal",
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Votre code postal doit contenir {{ limit }} chiffres',
                        'max' => 5,
                    ]),
                ],
            ])

            ->add('city',TextType::class,  [
                'attr' => ['placeholder' => "Veuillez renseigner votre ville"],
                'label' => 'Votre ville :',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer votre ville",
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre ville doit contenir {{ limit }} caractères minimum',
                        'max' => 4096,
                    ]),
                ],
                ])

            ->add('birth_date',BirthdayType::class,[
                'label' => 'Votre date de naissance :',
                'placeholder' => [
                    'day' => 'Jour', 'month' => 'Mois',  'year' => 'Année',
                ],
                'format' => 'dd-MM-yyyy'
            ])

            ->add('sex', ChoiceType::class, [
                'label' => 'Votre sexe :',
                'choices'  => [
                    'Monsieur' => "M",
                    'Madame' => "Mme",
                    'Mademoiselle' => "Mlle",
                ],
                'expanded' => true,
                'multiple' => false,
            ])

            ->add('phone',TextType::class,[
                'label' => 'Votre numéro de téléphone :',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer votre numéro de téléphone",
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre numéro de téléphone doit contenir {{ limit }} caractères',
                        'max' => 10,
                    ]),
                    
                    ],
            ])

            ->add('enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}