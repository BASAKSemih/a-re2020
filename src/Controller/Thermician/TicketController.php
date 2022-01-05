<?php

declare(strict_types=1);

namespace App\Controller\Thermician;

use App\Entity\Project;
use App\Entity\Remark;
use App\Entity\Thermician;
use App\Entity\Ticket;
use App\Form\RemarkType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'thermician_ticket_')]
final class TicketController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager, protected ProjectRepository $projectRepository)
    {
    }

    #[Route('/thermician/projets/{idProject}/prendre', name: 'take')]
    public function takeTicket(int $idProject): Response
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

    #[Route('/thermician/projets/{idProject}/show/ticket', name: 'show')]
    public function showTicket(int $idProject, Request $request): Response
    {
        /** @var Project $project */
        $project = $this->projectRepository->findOneById($idProject);
        /* @phpstan-ignore-next-line */
        if (!$project) {
            $this->addFlash('warning', "ce project n'existe pas");
            return $this->redirectToRoute('thermician_home');
        }
        /** @var Thermician $thermician */
        $thermician = $this->getUser();
        /** @var Ticket $ticket */
        $ticket = $project->getTicket();
        if (!$ticket->getActiveThermician() === $thermician) {
            $this->addFlash('warning', "Ce ticket ne vous appartient pas ");
            return $this->redirectToRoute('thermician_home');
        }
        $remark = new Remark();
        $form = $this->createForm(RemarkType::class, $remark)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $remark->setProject($project);
            $remark->setThermician($thermician);
            $this->entityManager->persist($remark);
            $this->entityManager->flush();
            $this->addFlash('success', "La remarque à été ajouter");
            return $this->redirectToRoute('thermician_ticket_show', ['idProject' => $idProject]);
        }
        return $this->render('thermician/ticket/show.html.twig', [
            'project' => $project,
            'form' => $form->createView()
        ]);
    }
}