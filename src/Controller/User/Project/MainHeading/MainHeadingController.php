<?php

declare(strict_types=1);

namespace App\Controller\User\Project\MainHeading;

use App\Entity\MainHeading;
use App\Form\MainHeadingType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'mainHeading_')]
final class MainHeadingController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProjectRepository $projectRepository,
        protected UserRepository $userRepository)
    {
    }

    #[Route('/espace-client/crée/mainHeading/{idProject}', name: 'create')]
    public function createMainHeading(int $idProject, Request $request): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('warning', 'Vous devez être connecter pour crée un projets');

            return $this->redirectToRoute('security_login');
        }
        $project = $this->projectRepository->findOneById($idProject);
        if (!$project) {
            $this->addFlash('warning', "Ce projet n'existe pas");

            return $this->redirectToRoute('project_create');
        }
        if ($project->getMainHeading()) {
            $this->addFlash('warning', 'Donné deja valider veuillez modifier mainHeading');

            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        if ($project->getUser() !== $user) {
            $this->addFlash('warning', 'Ceci ne vous appartient pas');

            return $this->redirectToRoute('homePage');
        }
        $mainHeading = new MainHeading();
        $form = $this->createForm(MainHeadingType::class, $mainHeading)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mainHeading->setProject($project);
            $this->entityManager->persist($mainHeading);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok create mainHeading');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/mainHeading/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/espace-client/edit/mainHeading/{idProject}', name: 'edit')]
    public function editMainHeading(int $idProject, Request $request): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('warning', 'Vous devez être connecter pour crée un projets');

            return $this->redirectToRoute('security_login');
        }
        $project = $this->projectRepository->findOneById($idProject);
        if (!$project) {
            $this->addFlash('warning', "Ce projet n'existe pas");

            return $this->redirectToRoute('project_create');
        }
        if (!$project->getMainHeading()) {
            $this->addFlash('warning', 'Donné pas valider veuillez crée carpentry');

            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        if ($project->getUser() !== $user) {
            $this->addFlash('warning', 'Ceci ne vous appartient pas');

            return $this->redirectToRoute('homePage');
        }
        $mainHeading = $project->getMainHeading();
        $form = $this->createForm(MainHeadingType::class, $mainHeading)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok edit mainHeading');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/mainHeading/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
