<?php

declare(strict_types=1);

namespace App\Controller\User\Project\Comment;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'comment_')]
final class CommentController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProjectRepository $projectRepository,
        protected UserRepository $userRepository
    ) {
    }

    #[Route('/espace-client/crée/comment/{idProject}', name: 'create')]
    public function createComment(int $idProject, Request $request): Response
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
        if ($project->getComment()) {
            $this->addFlash('warning', 'Donné deja valider veuillez modifier Comment');

            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        if ($project->getUser() !== $user) {
            $this->addFlash('warning', 'Ceci ne vous appartient pas');

            return $this->redirectToRoute('homePage');
        }
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setProject($project);
            $this->entityManager->persist($comment);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok create comment');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/comment/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/espace-client/edit/comment/{idProject}', name: 'edit')]
    public function editComment(int $idProject, Request $request): Response
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
        if (!$project->getComment()) {
            $this->addFlash('warning', 'Donné pas valider veuillez crée Ventilation');

            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        if ($project->getUser() !== $user) {
            $this->addFlash('warning', 'Ceci ne vous appartient pas');

            return $this->redirectToRoute('homePage');
        }
        $comment = $project->getComment();
        $form = $this->createForm(CommentType::class, $comment)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Ok edit comment');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/comment/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
