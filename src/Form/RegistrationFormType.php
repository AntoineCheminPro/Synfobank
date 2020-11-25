<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => "Veuillez renseigner votre adresse email"],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'attr' => [ 'placeholder' => "Veuillez renseigner votre mot de passe"],
                'mapped' => false,
                'label' => 'votre mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un mot de passe",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class,  [            
                'attr' => ['placeholder' => "Veuillez renseigner votre nom"],
                'label' => 'votre nom',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un Nom",
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('lastname', TextType::class,  [            
                'attr' => ['placeholder' => "Veuillez renseigner votre prénom"],
                'label' => 'votre prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un prénom",
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),

                ],
            ])
            ->add('adress', TextType::class,  [            
                'attr' => ['placeholder' => "Veuillez renseigner votre adresse"],
                'label' => 'votre adresse',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer une adresse",
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre adresse doit contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('city_code',TextType::class,  [            
                'attr' => ['placeholder' => "Veuillez renseigner votre code postal"],
                'label' => 'votre code postal'
                ])
            ->add('city',TextType::class,  [            
                'attr' => ['placeholder' => "Veuillez renseigner votre ville"],
                'label' => 'votre ville'
                ])
            ->add('birth_date',BirthdayType::class,[
                'label' => 'votre date de naissance',
                'placeholder' => [
                    'day' => 'Jour', 'month' => 'Mois',  'year' => 'Année', 
                ]
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'votre sexe',
                'choices'  => [
                    'Monsieur' => "M",
                    'Madame' => "Mme",
                    'Mademoiselle' => "Mlle",
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('phone',TextType::class,[
                'label' => 'votre numéro de téléphone'
            ],
            )
            ->add('enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}