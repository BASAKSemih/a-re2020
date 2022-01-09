<?php

namespace App\Tests\Thermician;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class ThermicianTicketTest extends WebTestCase
{
    public function testHomePageThermicianAccount(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_security_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'admin@test.com',
            'password' => '12',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('thermician_home');
    }

    public function testThermicianShowTicket(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_security_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'admin@test.com',
            'password' => '12',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('thermician_home');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('company+0');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_show_ticket', [
            'idProject' => $project->getId(),
        ]));
        $this->assertResponseStatusCodeSame(200);
        self::assertRouteSame('thermician_show_ticket');
    }

    public function testThermicianTakeATicket(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_security_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'admin@test.com',
            'password' => '12',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('thermician_home');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('company+0');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_take_ticket', [
            'idProject' => $project->getId(),
        ]));
        $client->followRedirect();
        self::assertRouteSame('thermician_show_my_ticket');
    }

    public function testSecondThermicianTryToPickATicketWhoAlreadyTaked(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_security_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'admin2@test.com',
            'password' => '12',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('thermician_home');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('company+0');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_take_ticket', [
            'idProject' => $project->getId(),
        ]));
        $client->followRedirect();
        self::assertRouteSame('thermician_home');
    }

//    public function testThermicianShowTicketWhoIsAlreadyTaked(): void
//    {
//        $client = static::createClient();
//        /** @var RouterInterface $router */
//        $router = $client->getContainer()->get('router');
//        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_security_login'));
//        $form = $crawler->filter('form[name=login]')->form([
//            'email' => 'admin2@test.com',
//            'password' => '12',
//        ]);
//
//        $client->submit($form);
//        $client->followRedirect();
//        self::assertRouteSame('thermician_home');
//
//        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
//        $projectRepository = $entityManager->getRepository(Project::class);
//        /** @var Project $project */
//        $project = $projectRepository->findOneByCompany('company+0');
//        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_show_ticket', [
//            'idProject' => $project->getId(),
//        ]));
//        $client->followRedirect();
//        self::assertRouteSame('thermician_home');
//    }

    public function testThermicianCreateARemarkOnTakedTicket(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_security_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'admin@test.com',
            'password' => '12',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('thermician_home');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('company+0');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_create_remark_ticket', [
            'idProject' => $project->getId(),
        ]));
        self::assertRouteSame('thermician_create_remark_ticket');
        $form = $crawler->filter('form[name=remark]')->form([
            'remark[title]' => 'Titre Remark',
            'remark[content]' => 'Content',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('thermician_home');
    }

    public function testThermicianTakeATicketAfterRemarkTheOtherTicket(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_security_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'admin@test.com',
            'password' => '12',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('thermician_home');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('company+1');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_take_ticket', [
            'idProject' => $project->getId(),
        ]));
        $client->followRedirect();
        self::assertRouteSame('thermician_show_my_ticket');
    }

    public function testThermicianCreateRemarkOnNotMyTicket(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_security_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'admin2@test.com',
            'password' => '12',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('thermician_home');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('company+1');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('thermician_create_remark_ticket', [
            'idProject' => $project->getId(),
        ]));
        $client->followRedirect();
        self::assertRouteSame('thermician_home');
    }
}
