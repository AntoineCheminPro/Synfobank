<?php

namespace App\Form;

use App\Entity\Operation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransfertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('debitAccount', EntityType::class, [
            "label" => "Compte à débiter",
            "class" => Account::class,
            "choice_label" => function($account) {
              return $account->getType() . " (" . $account->getAmount() . ")";
            },
            // Define the accounts to chose from by a request to the user account
            "choices" => $this->security->getUser()->getAccounts()
          ])
          ->add('creditAccount', EntityType::class, [
            "label" => "Compte à créditer",
            "class" => Account::class,
            "choice_label" => function($account) {
              return $account->getType() . " (" . $account->getAmount() . ")";
            },
            "choices" => $this->security->getUser()->getAccounts()
          ])
            ->add('amount')
            ->add('registered')
            ->add('label')
            ->add('Account')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
