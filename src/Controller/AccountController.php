<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Account;
use App\Entity\Operation;

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
     * @Route("/account/{id}", name="account", requirements={"id"="\d+"})
     */
    public function single(int $id): Response
    {
        $user = $this->getUser();
        $accountRepository = $this->getDoctrine()
            ->getRepository(Account::class);
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
