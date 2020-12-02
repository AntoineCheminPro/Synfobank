<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class AccountCreationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', NumberType::class, [
              'scale' => 2,
              'label'=> 'Montant :',
            ])

            ->add('account_type', ChoiceType::class, [
              'choices'  => Account::TYPES,
              'label' => 'Type de compte :',
              // callback function to get the value and not the key from the types array
              'choice_label' => function ($choice, $key, $value) {
                return $value;
              },
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
            'data_class' => Account::class,
        ]);
    }
}