<?php

declare(strict_types=1);

namespace App\Controller\User\Project\Remark;

use App\Repository\ProjectRepository;
use App\Repository\RemarkRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @SuppressWarnings
 */
#[Route(name: 'remark_')]
#[IsGranted('ROLE_USER')]
final class RemarkController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProjectRepository $projectRepository,
        protected UserRepository $userRepository,
        protected Security $security,
        protected RemarkRepository $remarkRepository
    ) {
    }

    #[Route('/espace-client/showAll/remark/{idProject}', name: 'show_all')]
    public function showAllRemark(int $idProject): Response
    {
        $project = $this->projectRepository->findOneById($idProject);
        if (!$project) {
            $this->addFlash('warning', "Ce projet n'existe pas");

            return $this->redirectToRoute('project_create');
        }
        /* @phpstan-ignore-next-line */
        if (!$project->getRemarks()) {
            $this->addFlash('warning', 'Erreur pas de remarques');

            return $this->redirectToRoute('homePage');
        }
        $remarks = $this->remarkRepository->findByProject($project);
        if (!$remarks) {
            $this->addFlash('warning', 'Erreur pas de remarques');

            return $this->redirectToRoute('homePage');
        }
        $this->security->isGranted('IS_OWNER', $project);
        $this->denyAccessUnlessGranted('IS_OWNER', $project, 'Pas proprio');

        return $this->render('user/project/remark/show_all.html.twig', [
            'remarks' => $remarks,
        ]);
    }

    #[Route('/espace-client/show/remark/{idProject}/{idRemark}', name: 'show')]
    public function showRemark(int $idProject, int $idRemark): Response
    {
        $project = $this->projectRepository->findOneById($idProject);
        if (!$project) {
            $this->addFlash('warning', "Ce projet n'existe pas");

            return $this->redirectToRoute('project_create');
        }
        /* @phpstan-ignore-next-line */
        if (!$project->getRemarks()) {
            $this->addFlash('warning', 'Erreur pas de remarques');

            return $this->redirectToRoute('homePage');
        }
        $remark = $this->remarkRepository->findOneById($idRemark);
        if (!$remark) {
            $this->addFlash('warning', 'Erreur pas de remarques');

            return $this->redirectToRoute('homePage');
        }
        $this->security->isGranted('IS_OWNER', $project);
        $this->denyAccessUnlessGranted('IS_OWNER', $project, 'Pas proprio');

        return $this->render('user/project/remark/show.html.twig', [
            'remark' => $remark,
        ]);
    }
}
