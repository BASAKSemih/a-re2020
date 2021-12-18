<?php

namespace App\Controller\User\Project\Building;

use App\Entity\Building;
use App\Entity\User;
use App\Form\BuildingType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'building_')]
class BuildingController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager, protected ProjectRepository $projectRepository, protected UserRepository $userRepository)
    {
    }

    #[Route('/espace-client/parois/{idProject}', name: 'create')]
    public function createBuilding(int $idProject, Request $request): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('warning', 'Vous devez être connecter pour crée un projets');
            return $this->redirectToRoute('security_login');
        }
        $project = $this->projectRepository->findOneById($idProject);
        if (!$project){
            $this->addFlash('warning', "Ce projet n'existe pas");
            return $this->redirectToRoute('project_create');
        }
        if ($project->getBuilding()){
            $this->addFlash('warning', "Donné deja valider veuillez modifier building");
            return $this->redirectToRoute('homePage');
        }
        $user = $this->getUser();
        /** @phpstan-ignore-next-line */
        if (!$project->getUser() === $user){
            $this->addFlash('warning', "Ceci ne vous appartient pas");
            return $this->redirectToRoute('homePage');
        }
        $building = new Building();
        $form = $this->createForm(BuildingType::class, $building)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $building->setProject($project);
            $this->entityManager->persist($building);
            $this->entityManager->flush();
            $this->addFlash('success', "Ok create building");
            return $this->redirectToRoute('homePage');
            }
        return $this->render('user/project/building/create.html.twig', [
            'form' => $form->createView()
        ]);

    }

}