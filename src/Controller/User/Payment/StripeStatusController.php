<?php

declare(strict_types=1);

namespace App\Controller\User\Payment;

use App\Repository\BillingRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 *  @SuppressWarnings(PHPMD)
 */
#[Route(name: 'status_')]
#[IsGranted('ROLE_USER')]
final class StripeStatusController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProjectRepository $projectRepository,
        protected BillingRepository $billingRepository,
        protected Security $security
    ) {
    }

    #[Route('/espace-client/projet/{CHECKOUT_SESSION_ID}/paiement/succes', name: 'success')]
    public function successPayment(string $CHECKOUT_SESSION_ID): Response
    {
        $billing = $this->billingRepository->findOneByStripeSessionId($CHECKOUT_SESSION_ID);
        $project = $billing->getProject();
        $this->security->isGranted('IS_OWNER', $project);
        $this->denyAccessUnlessGranted('IS_OWNER', $project, 'Pas proprio');

        $billing->setIsPaid(true);
        $this->entityManager->flush();

        return $this->render('user/payment/success.html.twig');
    }

    #[Route('/espace-client/projet/{CHECKOUT_SESSION_ID}/paiement/erreur', name: 'error')]
    public function errorPayment(string $CHECKOUT_SESSION_ID): Response
    {
        $billing = $this->billingRepository->findOneByStripeSessionId($CHECKOUT_SESSION_ID);

        $project = $billing->getProject();
        $this->security->isGranted('IS_OWNER', $project);
        $this->denyAccessUnlessGranted('IS_OWNER', $project, 'Pas proprio');

        $billing->setUser(null);
        $this->entityManager->flush();

        return $this->render('user/payment/error.html.twig');
    }
}
