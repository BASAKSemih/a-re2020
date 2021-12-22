<?php

declare(strict_types=1);

namespace App\Controller\User\Payment;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'payment_')]
#[IsGranted('ROLE_USER')]
final class StripeController extends AbstractController
{

    #[Route('/espace-client/{idOffer}/{idProject}', name: 'create')]
    public function createPayment(int $idOffer, int $idProject): Response
    {
        return $this->render('user/payment/create.html.twig');
    }
}