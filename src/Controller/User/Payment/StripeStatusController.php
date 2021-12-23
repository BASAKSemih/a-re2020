<?php

namespace App\Controller\User\Payment;

use App\Entity\Billing;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'status_')]
class StripeStatusController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager, protected ProjectRepository $projectRepository)
    {
    }

    #[Route('/espace-client/projet/{idProject}/paiement/succes', name: 'success')]
    public function successPayment(int $idProject): Response
    {
        $project = $this->projectRepository->findOneById($idProject);
        /** @var Billing $billing */
        $billing = $project->getBilling();
        $billing->setIsPaid(true);
        $this->entityManager->flush();

        return $this->render('user/payment/success.html.twig');
    }

    #[Route('/espace-client/projet/{idProject}/paiement/erreur', name: 'error')]
    public function errorPayment(): Response
    {
        return $this->render('user/payment/error.html.twig');
    }
}
