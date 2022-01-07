<?php

namespace App\DataFixtures\Project;

use App\Entity\Owner;
use App\Entity\Project;
use App\Entity\Ticket;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProjectFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager)
    {
        for ($u = 0; $u <= 3; ++$u) {
            $user = new User();
            $user
                ->setEmail(sprintf('userticket+%d@email.com', $u))
                ->setFirstName(sprintf('firstName+%d', $u))
                ->setLastName(sprintf('lastName+%d', $u))
                ->setIsVerified(true)
                ->setPassword($this->userPasswordHasher->hashPassword($user, 'password'));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $manager->flush();
            for ($p = 0;$p <=1; ++$p) {
                $project = new Project();
                $project
                    ->setFirstName(sprintf('firstName+%d', $u))
                    ->setLastName(sprintf('lastName+%d', $u))
                    ->setAddress(sprintf('adress+%d', $p))
                    ->setCity(sprintf('city+%d', $p))
                    ->setPostalCode(sprintf('postal+%d', $p))
                    ->setCompany(sprintf('company+%d', $p))
                    ->setPhoneNumber(sprintf('phoneNumber+%d', $p))
                    ->setEmail($user->getEmail())
                    ->setMasterJob('ARCHITECTE')
                    ->setCadastralReference(sprintf('cadastralRef+%d', $p))
                    ->setProjectLocation('VILLAGE')
                    ->setProjectType('CONSTRUCTION')
                    ->setConstructionPlanDate(new DateTime())
                    ->setUser($user)
                    ->setProjectName(sprintf('projectName+%d', $p));

                $owner = new Owner();
                $owner
                    ->setAddress(sprintf('adress+%d', $p))
                    ->setCity(sprintf('city+%d', $p))
                    ->setPostalCode(sprintf('postal+%d', $p))
                    ->setFirstName(sprintf('firstName+%d', $p))
                    ->setLastName(sprintf('lastName+%d', $p));
                $manager->persist($owner);
                $project->setOwnerProject($owner);
                $manager->persist($project);
                $project->setStatus(Project::STATUS_PAID);

                $ticket = new Ticket();
                $ticket->setProject($project);
                $manager->persist($ticket);
                $manager->flush();

            }
            $manager->flush();
        }
    }
}