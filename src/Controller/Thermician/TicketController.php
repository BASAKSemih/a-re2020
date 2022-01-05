<?php

declare(strict_types=1);

namespace App\Controller\Thermician;

use App\Entity\Project;
use App\Entity\Thermician;
use App\Entity\Ticket;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'thermician_ticket_')]
final class TicketController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager, protected ProjectRepository $projectRepository)
    {
    }

    #[Route('/thermician/projets/{idProject}/prendre', name: 'take')]
    public function showProject(int $idProject): Response
    {
        /** @var Project $project */
        $project = $this->projectRepository->findOneById($idProject);
        /* @phpstan-ignore-next-line */
        if (!$project) {
            $this->addFlash('warning', "ce project n'existe pas");
            return $this->redirectToRoute('thermician_home');
        }
        /** @var Ticket $ticket */
        $ticket = $project->getTicket();
        if ($ticket->getActiveThermician()) {
            $this->addFlash('warning', "ce ticket est déjà pris");
            return $this->redirectToRoute('thermician_home');
        }
        /** @var Thermician $thermician */
        $thermician = $this->getUser();
        $ticket->setActiveThermician($thermician);
        $this->entityManager->flush();
        $this->addFlash('success', "Vous avez pris le ticket");
        return $this->redirectToRoute('thermician_home');
    }
}