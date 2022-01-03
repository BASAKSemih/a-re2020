<?php

declare(strict_types=1);

namespace App\Controller\Thermician;

use App\Entity\User;
use App\Repository\TicketRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'thermician_')]
final class ThermicianController extends AbstractController
{
    /* @phpstan-ignore-next-line */
    protected array $role = ['ROLE_THERMICIAN'];

    public function __construct(protected TicketRepository $ticketRepository)
    {
    }

    #[Route('/espace-thermicien/accueil', name: 'home')]
    public function home(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $tickets = $this->ticketRepository->findAll();
        if ($user->getRoles() !== $this->role) {
            $this->addFlash('danger', 'Erreur accès pasge thermician');
            return $this->redirectToRoute('homePage');
        }
        return $this->render('thermician/home.html.twig', [
            'tickets' => $tickets
        ]);
    }

}