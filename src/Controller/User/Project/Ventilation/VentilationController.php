<?php

declare(strict_types=1);

namespace App\Controller\User\Project\Ventilation;

use App\Entity\Ventilation;
use App\Form\VentilationType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'ventilation_')]
final class VentilationController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProjectRepository $projectRepository,
        protected UserRepository $userRepository)
    {
    }

    #[Route('/espace-client/crée/ventilation/{idProject}', name: 'create')]
    public function createVentilation(int $idProject, Request $request): Response
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
        if ($project->getVentilation()) {
            $this->addFlash('warning', 'Donné deja valider veuillez modifier ventilation');

            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        if ($project->getUser() !== $user) {
            $this->addFlash('warning', 'Ceci ne vous appartient pas');

            return $this->redirectToRoute('homePage');
        }
        $ventilation = new Ventilation();
        $form = $this->createForm(VentilationType::class, $ventilation)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ventilation->setProject($project);
            $this->entityManager->persist($ventilation);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok create ventilation');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/ventilation/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/espace-client/edit/ventilation/{idProject}', name: 'edit')]
    public function editVentilation(int $idProject, Request $request): Response
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
        if (!$project->getVentilation()) {
            $this->addFlash('warning', 'Donné pas valider veuillez crée Ventilation');

            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        if ($project->getUser() !== $user) {
            $this->addFlash('warning', 'Ceci ne vous appartient pas');

            return $this->redirectToRoute('homePage');
        }
        $ventilation = $project->getVentilation();
        $form = $this->createForm(VentilationType::class, $ventilation)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok edit ventilation');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/ventilation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
