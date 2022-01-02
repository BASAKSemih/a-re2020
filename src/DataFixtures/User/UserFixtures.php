<?php

declare(strict_types=1);

namespace App\DataFixtures\User;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($index = 1; $index <= 10; ++$index) {
            $user = new User();
            $user
                ->setEmail(sprintf('user+%d@email.com', $index))
                ->setFirstName(sprintf('firstname+%d', $index))
                ->setIsVerified(true)
                ->setLastName(sprintf('firstname+%d', $index))
                ->setPassword($this->userPasswordHasher->hashPassword($user, 'password'));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
