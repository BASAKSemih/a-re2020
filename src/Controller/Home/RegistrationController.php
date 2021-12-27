<?php

declare(strict_types=1);

namespace App\Controller\Home;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected UserRepository $userRepository,
        protected UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    #[Route('/inscription', name: 'security_register')]
    public function register(Request $request): Response
    {
        if ($this->getUser()) {
            $this->addFlash('warning', 'Vous êtes connecter, vous ne pouvez pas vous inscrire');

            return $this->redirectToRoute('homePage');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $checkEmail = $this->userRepository->findOneByEmail($user->getEmail());
            if (!$checkEmail) {
                $passwordHash = $this->passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($passwordHash);
                $user->setValidationToken($this->generateToken());
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $this->addFlash('success', 'Votre compte à bien été crée');

                return $this->redirectToRoute('homePage');
            }
            $form = $this->createForm(UserType::class, $user)->handleRequest($request);
            $this->addFlash('warning', 'Cette adresse email est déjà utiliser');

            return $this->render('security/register.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function generateToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
