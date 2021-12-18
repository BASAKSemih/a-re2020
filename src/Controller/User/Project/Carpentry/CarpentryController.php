<?php

declare(strict_types=1);

namespace App\Controller\User\Project\Carpentry;

use App\Entity\Carpentry;
use App\Form\CarpentryType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @SuppressWarnings
 */
#[Route(name: 'carpentry_')]
final class CarpentryController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProjectRepository $projectRepository,
        protected UserRepository $userRepository)
    {
    }

    #[Route('/espace-client/crée/carpentry/{idProject}', name: 'create')]
    public function createCarpentry(int $idProject, Request $request): Response
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
        if ($project->getCarpentry()) {
            $this->addFlash('warning', 'Donné deja valider veuillez modifier building');
            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        if ($project->getUser() !== $user) {
            $this->addFlash('warning', 'Ceci ne vous appartient pas');

            return $this->redirectToRoute('homePage');
        }
        $carpentry = new Carpentry();
        $form = $this->createForm(CarpentryType::class, $carpentry)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $carpentry->setProject($project);
            $this->entityManager->persist($carpentry);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok create carpentry');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/carpentry/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/espace-client/edit/carpentry/{idProject}', name: 'edit')]
    public function editCarpentry(int $idProject, Request $request): Response
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
        if (!$project->getCarpentry()) {
            $this->addFlash('warning', 'Donné pas valider veuillez crée carpentry');
            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        if ($project->getUser() !== $user) {
            $this->addFlash('warning', 'Ceci ne vous appartient pas');

            return $this->redirectToRoute('homePage');
        }
        $carpentry = $project->getCarpentry();
        $form = $this->createForm(CarpentryType::class, $carpentry)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok edit carpentry');
            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/carpentry/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
