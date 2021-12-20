<?php

namespace App\Controller\User\Project\SecondaryHeading;

use App\Entity\SecondaryHeading;
use App\Form\SecondaryHeadingType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'secondaryHeading_')]
class SecondaryHeadingController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProjectRepository $projectRepository,
        protected UserRepository $userRepository)
    {
    }

    #[Route('/espace-client/crée/secondaryHeading/{idProject}', name: 'create')]
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
        if ($project->getSecondaryHeading()) {
            $this->addFlash('warning', 'Donné deja valider veuillez modifier mainHeading');
            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        if ($project->getUser() !== $user) {
            $this->addFlash('warning', 'Ceci ne vous appartient pas');
            return $this->redirectToRoute('homePage');
        }
        $secondaryHeading = new SecondaryHeading();
        $form = $this->createForm(SecondaryHeadingType::class, $secondaryHeading)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $secondaryHeading->setProject($project);
            $this->entityManager->persist($secondaryHeading);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok create secondaryHeading');
            return $this->redirectToRoute('homePage');
        }
        return $this->render('user/project/secondaryHeading/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

}