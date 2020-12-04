<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Entity\User;
use App\Entity\Account;
use App\Form\OperationType;
use App\Repository\OperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/operation")
 */
class OperationController extends AbstractController
{
    /**
     * @Route("/", name="operation_index", methods={"GET"})
     */
    public function index(OperationRepository $operationRepository): Response
    {
        return $this->render('operation/index.html.twig', [
            'operations' => $operationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="operation_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $id): Response
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);
        $date = new \DateTime(date('d-m-Y'));

        $accountRepository = $this->getDoctrine()->getRepository(Account::class);
        $account =$accountRepository->findAccountOperationByAccountId($id);

        $sold = $account->getAmount();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $operation->setRegistered($date);
            $operation->setAccount($account);
            // switch account amount with new amount
            $type = $operation->getOperationType();
            $amount = $operation->getAmount();
            ($type === "Débit"? $amount = -1*$amount:$amount=$amount);
            $newSold = $sold + $amount;
            $account->setAmount($newSold);
            $operation->setAmount($amount);
            // persiste data in DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operation);
            $entityManager->persist($account);

            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('operation/new.html.twig', [
            'operation' => $operation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="operation_show", methods={"GET"})
     */
    public function show(Operation $operation): Response
    {
        return $this->render('operation/show.html.twig', [
            'operation' => $operation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="operation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Operation $operation): Response
    {
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operation_index');
        }

        return $this->render('operation/edit.html.twig', [
            'operation' => $operation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="operation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Operation $operation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('operation_index');
    }
}
