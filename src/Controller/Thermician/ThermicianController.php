<?php

declare(strict_types=1);

namespace App\Controller\Thermician;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'thermician_')]
#[IsGranted('THERMICIAN')]
final class ThermicianController extends AbstractController
{
    #[Route('/espace-thermicien/accueil', name: 'home')]
    public function home(): Response
    {
        return $this->render('thermician/home.html.twig');
    }

}