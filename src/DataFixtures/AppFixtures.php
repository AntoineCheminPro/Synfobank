<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Account;
use App\Entity\Operation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // use the factory to create a Faker\Generator instance
        $mail = ["orange.fr", "free.fr", "sfr.fr", "gmail.com", "outlook.fr"];
        $cities =[
            [76000, "rouen"], 
            [27500, "pont-audemer"],
            [76380, "Canteleu"],
            [76800, "Saint-Etienne-du-Rouveray"],
            [76530, "Grand-Couronne"]
        ];
        $LastNames =["Martin", "Dupont", "Durand", "Duval", "Gossart", "Chemin", "Kouassi", "Roche", "Feuille", "Singh"];
        $FirstNames = [["M", "Olivier"],["M", "Thomas"],["Mme", "Aurélie"],
                        ["Mme", "Agnès"],
                        ["M","Antoine"],
                        ["Mlle", "Anaïs"],
                        ["M", "Armand"],
                        ["Mme", "Florence"],
                        ["M", "Gilles"],
                        ["Mme", "Isabelle"]];
        $streets= ["25 rue du terrain", "12 rue de la république", "32 place de la mairie", "13 rue de la poste", "11 avenue Gambetta"];
        $accountTypes = ["compte commun", "compte courant", "livret A", "PEL"];
        $operationTypes = ["Débit", "Crédit"];
        $date = new \DateTime(date('d-m-Y'));
        
        for ($i = 0; $i < 10; $i++)
        {
            $city = $cities[array_rand($cities,1)];
            $user = new User();
            $firstname = $FirstNames[array_rand($FirstNames,1)];
            $lastname = $LastNames[array_rand($LastNames,1)];
            $user->setFirstname($firstname[1]);
            $user->setLastname($lastname);
            $user->setEmail($firstname[1].$lastname."@".$mail[array_rand($mail,1)]);
            $user->setCity($city[1]);
            $user->setCityCode($city[0]);
            $user->setAdress($streets[array_rand($streets,1)]);
            $user->setPhone("0606060606");
            $user->setPassword("password1");
            $user->setBirthDate($date); 
            $user->setSex($firstname[0]);
            $manager->persist($user);
            foreach ($accountTypes as $accountType){
                $account = new Account();
                $account->setAmount(mt_rand(10, 100)*100);
                $account->setAccountType($accountType);
                $account->setOpeningDate($date);
                $account->setUser($user);
                $manager->persist($account);
                for ($j = 0; $j < 5; $j++){
                    $operation = new Operation();
                    $operationType = $operationTypes[array_rand($operationTypes,1)];
                    $operation->setOperationType($operationType);
                    $operation->setAmount(mt_rand(10, 100)*($operationType == "Crédit"?10 : -10));
                    $operation->setRegistered($date);
                    $operation->setLabel("lorem ipsum");
                    $operation->setAccount($account);
                    $manager->persist($operation);
                }
            }
        }
        $manager->flush();
    }

}

