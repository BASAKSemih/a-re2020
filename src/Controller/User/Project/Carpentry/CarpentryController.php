<?php

declare(strict_types=1);

namespace App\Controller\User\Project\Carpentry;

use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    }

}