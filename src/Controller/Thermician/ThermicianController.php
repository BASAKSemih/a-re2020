<?php

namespace App\Controller\Thermician;

use App\Entity\Project;
use App\Entity\Thermician;
use App\Entity\User;
use App\Repository\ProjectRepository;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'thermician_')]
class ThermicianController extends AbstractController
{
    public function __construct(protected TicketRepository $ticketRepository, protected ProjectRepository $projectRepository)
    {
    }

    #[Route('/thermician/accueil', name: 'home')]
    public function home(): Response
    {
        /** @var Thermician $thermician */
        $thermician = $this->getUser();
        $tickets = $this->ticketRepository->findAll();
        $thermicianTicket = $this->ticketRepository->findOneByActiveThermician($thermician);
        if (!$thermicianTicket) {
            return $this->render('thermician/home.html.twig', [
                'tickets' => $tickets
            ]);
        }
        return $this->render('thermician/home.html.twig', [
            'tickets' => $tickets,
            'activeTicket' => $thermicianTicket
        ]);
    }

    #[Route('/thermician/projets/{idProject}', name: 'show_project')]
    public function showProject(int $idProject): Response
    {
        /** @var Project $project */
        $project = $this->projectRepository->findOneById($idProject);
        /* @phpstan-ignore-next-line */
        if (!$project) {
            $this->addFlash('warning', "ce project n'existe pas");
            return $this->redirectToRoute('thermician_home');
        }
        return $this->render('thermician/project/show.html.twig', [
            'project' => $project
        ]);
    }
}