<?php

namespace App\DataFixtures\Thermician;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ThermicianFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setEmail('semihbasak25@gmail.com')
            ->setFirstName('Semih')
            ->setIsVerified(true)
            ->setLastName('Basak')
            ->setPassword($this->userPasswordHasher->hashPassword($user, '12'));
        $user->setRoles(['THERMICIAN']);
        $manager->persist($user);
        $manager->flush();
    }
}