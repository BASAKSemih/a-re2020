<?php

declare(strict_types=1);

namespace App\Controller\User\Project\Building;

use App\Entity\Building;
use App\Entity\Plan;
use App\Form\BuildingType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @SuppressWarnings
 */
#[Route(name: 'building_')]
#[IsGranted('ROLE_USER')]
final class BuildingController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProjectRepository $projectRepository,
        protected UserRepository $userRepository,
        protected Security $security
    ) {
    }

    #[Route('/espace-client/crée/{idProject}', name: 'create')]
    public function createBuilding(int $idProject, Request $request): Response
    {
        $project = $this->projectRepository->findOneById($idProject);
        if (!$project) {
            $this->addFlash('warning', "Ce projet n'existe pas");

            return $this->redirectToRoute('project_create');
        }
        if ($project->getBuilding()) {
            $this->addFlash('warning', 'Donné deja valider veuillez modifier building');

            return $this->redirectToRoute('homePage');
        }
        $this->security->isGranted('IS_OWNER', $project);
        $this->denyAccessUnlessGranted('IS_OWNER', $project, 'Pas proprio');

        $building = new Building();
        $form = $this->createForm(BuildingType::class, $building)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pdfs = $form->get('plan')->getData();
            foreach ($pdfs as $pdf) {
                $projectName = str_replace(" ","", $project->getProjectName());
                $file = md5(uniqid()) . $projectName. $project->getId(). '.' . $pdf->guessExtension();
                $pdf->move(
                    $this->getParameter('pdf_directory'),
                    $file
                );
                $plan = new Plan();
                $plan->setName($file);
                $building->addPlan($plan);
                $this->entityManager->persist($plan);
            }
            $building->setProject($project);
            $this->entityManager->persist($building);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok create building');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/building/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/espace-client/modifier/{idProject}', name: 'edit')]
    public function editBuilding(int $idProject, Request $request): Response
    {
        $project = $this->projectRepository->findOneById($idProject);
        if (!$project) {
            $this->addFlash('warning', "Ce projet n'existe pas");

            return $this->redirectToRoute('project_create');
        }
        if (!$project->getBuilding()) {
            $this->addFlash('warning', 'Donné inexistante');

            return $this->redirectToRoute('homePage');
        }
        $this->security->isGranted('IS_OWNER', $project);
        $this->denyAccessUnlessGranted('IS_OWNER', $project, 'Pas proprio');

        $building = $project->getBuilding();
        $form = $this->createForm(BuildingType::class, $building)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok edit building');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/building/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
