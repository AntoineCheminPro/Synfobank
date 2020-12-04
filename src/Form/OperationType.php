<?php

namespace App\Form;

use App\Entity\Operation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('operation_type', ChoiceType::class, [
                'label' => "type d'opération",
                'choices'  => [
                    'Débit' => "Débit",
                    'Crédit' => "Crédit",
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('amount', MoneyType::class, [
                'attr' => ['placeholder' => "Montant"],
                'label' => 'Montant',
                'constraints' => [
                    new Positive([
                        'message' => "Le montant ne peut être négatif",
                    ]),
                    new NotBlank([
                        'message' => "Merci d'entrer un montant pour cette opération",
                    ])],
            ])
            ->add('label',TextType::class,  [            
                'attr' => ['placeholder' => "Veuillez renseigner le libellé de l'opération"],
                'label' => 'Libellé',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un libellé pour cette opération",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre libellé doit contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])],
                ])
            
            ->add('enregistrer', SubmitType::class,[
                'attr' => [
                    "class" => "btn-info"
                    ]
                ])
    
            ;
    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
