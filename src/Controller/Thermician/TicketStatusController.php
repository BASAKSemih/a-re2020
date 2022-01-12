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

#[Route(name: 'thermician_')]
final class TicketStatusController extends AbstractController
{
    public function __construct(protected ProjectRepository $projectRepository, protected EntityManagerInterface $entityManager)
    {
    }

    #[Route('/thermician/projets/{idProject}/create/remark/ticket', name: 'create_remark_ticket')]
    public function createRemark(int $idProject, Request $request): Response
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
        if ($ticket->getActiveThermician() !== $thermician) {
            $this->addFlash('warning', 'Ce ticket ne vous appartient pas ');

            return $this->redirectToRoute('thermician_home');
        }
        $remark = new Remark();
        $form = $this->createForm(RemarkType::class, $remark)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $remark->setProject($project);
            $remark->setThermician($thermician);
            $remark->setProject($project);
            $thermician->setActiveTicket(null);
            $ticket->setOldThermician($thermician);
            $project->setStatus(Project::STATUS_ERROR_INFORMATION);
            $this->entityManager->persist($remark);
            $this->entityManager->flush();
            $this->addFlash('success', "La remarque à été envoyer a l'utilisateur, le ticket à été mis en pause vous pouvez séléctionner un autre ticket");

            return $this->redirectToRoute('thermician_home');
        }

        return $this->render('thermician/ticket/status/remark.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/thermician/projets/{idProject}/send/document/ticket', name: 'send_document')]
    public function sendDocument(): void
    {

    }
}
