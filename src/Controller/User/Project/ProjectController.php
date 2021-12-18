<?php

namespace App\Controller\User\Project;

use App\Entity\Owner;
use App\Entity\Project;
use App\Entity\User;
use App\Form\OwnerType;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'project_')]
class ProjectController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }


    #[Route('/espace-client/cree-un-projet', name: 'create')]
    public function createProject(Request $request): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('warning', 'Vous devez être connecter pour crée un projets');
            return $this->redirectToRoute('security_login');
        }

        $project = new Project();
        $ownerProject = new Owner();
        $projectForm = $this->createForm(ProjectType::class, $project)->handleRequest($request);
        $ownerForm = $this->createForm(OwnerType::class, $ownerProject)->handleRequest($request);
        if ($projectForm->isSubmitted() && $projectForm->isValid()) {
            /** @var User $user */
            $user = $this->getUser();
            $project->setUser($user);
            $project->setOwnerProject($ownerProject);
            $this->entityManager->persist($project);
            $this->entityManager->persist($ownerProject);
            $this->entityManager->flush();
            $this->addFlash('success', 'Le project à été crée');
            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/project/create.html.twig', [
            'projectForm' => $projectForm->createView(),
            'ownerForm' => $ownerForm->createView()
        ]);
    }

}