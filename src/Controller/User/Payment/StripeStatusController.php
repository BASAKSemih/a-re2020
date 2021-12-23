<?php

declare(strict_types=1);

namespace App\Controller\User\Payment;

use App\Entity\Billing;
use App\Repository\BillingRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'status_')]
final class StripeStatusController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager, protected ProjectRepository
    $projectRepository, protected BillingRepository $billingRepository)
    {
    }

    #[Route('/espace-client/projet/{CHECKOUT_SESSION_ID}/paiement/succes', name: 'success')]
    public function successPayment(string $CHECKOUT_SESSION_ID): Response
    {
        $billing = $this->billingRepository->findOneByStripeSessionId($CHECKOUT_SESSION_ID);
        $billing->setIsPaid(true);
        $this->entityManager->flush();

        return $this->render('user/payment/success.html.twig');
    }

    #[Route('/espace-client/projet/{CHECKOUT_SESSION_ID}/paiement/erreur', name: 'error')]
    public function errorPayment(string $CHECKOUT_SESSION_ID): Response
    {
        $billing = $this->billingRepository->findOneByStripeSessionId($CHECKOUT_SESSION_ID);
        dd($billing);
        return $this->render('user/payment/error.html.twig');
    }
}
