<?php

namespace App\Tests\User\Project\Comment;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class CommentTest extends WebTestCase
{
    public function testCreateComment(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'user@user.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('Carpentrycompany');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('comment_create', [
            'idProject' => $project->getId(),
        ]));
        self::assertRouteSame('comment_create');
        $form = $crawler->filter('form[name=comment]')->form([
            'comment[remark]' => 'Ma maison est belle',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }
}