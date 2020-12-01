<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\AccountCreationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
* @IsGranted("IS_AUTHENTICATED_FULLY")
*/
class AccountController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        // $user = $this->getUser();
        // $accountsRepository = $this->getDoctrine()
        //     ->getRepository(Account::class);
        // $accounts =$accountsRepository->findBy(array $user);

        // if (!$accounts) {
        //     throw $this->createNotFoundException(
        //         'No account found '
        //     );
        //     }

        // return $this->render('accounts/index.html.twig', [
        //     'accounts' => $accounts,
        // ]);
        return $this->render('accounts/index.html.twig');
    }

    /**
     * @Route("/accountCreation", name="accountCreation")
     */
    public function CreateAccount(Request $request): Response
        {
            $account = new Account();
            $form = $this->createForm(AccountCreationFormType::class, $account);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                // $account->setOpeningDate();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($account);
                $entityManager->flush();
                // do anything else you need here, like send an email
    
                return $this->redirectToRoute('index');
            }
    
            return $this->render('Accounts/accountCreation.html.twig', [
                'accountCreationForm' => $form->createView(),
            ]);
        }

    /**
     * @Route("/account/{id}", name="account", requirements={"id"="\d+"})
     */
    public function single(int $id): Response
    {
        $user = $this->getUser();
        $accountRepository = $this->getDoctrine()->getRepository(Account::class);
        $account =$accountRepository->findAccountOperationByAccountId($id);
        if (!$account) {
            throw $this->createNotFoundException(
                'No account found '
            );
            }

        return $this->render('account/index.html.twig', [
            'account' => $account,
        ]);


    }
}
