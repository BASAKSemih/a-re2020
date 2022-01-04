<?php

declare(strict_types=1);

namespace App\Controller\Thermician\Project;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'thermician_project_')]
final class ProjectShowController extends AbstractController
{
    public function __construct(protected ProjectRepository $projectRepository)
    {
    }

    #[Route('/espace-thermicien/projets/{idProject}', name: 'show')]
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