<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Account;


class AccountController extends AbstractController
{
    /**
     * @Route("/accounts", name="accounts")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $accountsRepository = $this->getDoctrine()
            ->getRepository(Account::class);
        $accounts =$accountsRepository->findAll();

        if (!$accounts) {
            throw $this->createNotFoundException(
                'No account found '
            );
            }

        return $this->render('accounts/index.html.twig', [
            'accounts' => $accounts,
        ]);
    }

    /**
     * @Route("/account/{id}", name="account", requirements={"id"="\d+"})
     */
    public function single(int $id): Response
    {
        $user = $this->getUser();
        $accountRepository = $this->getDoctrine()
            ->getRepository(Account::class);
        $account =$accountRepository->find($id);
        dump($account);
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
