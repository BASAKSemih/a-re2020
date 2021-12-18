<?php

namespace App\Tests\User\Project;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class ProjectTest extends WebTestCase
{
    public function testCreateProject(): void
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
        $crawler = $client->request(Request::METHOD_GET, $router->generate('project_create'));
        self::assertRouteSame('project_create');
        $form = $crawler->filter("form[name=owner]")->form([
            "owner[lastName]" => 'lastName',
            "owner[firstName]" => 'firstName',
            "owner[address]" => '21 rue Chamvalon',
            "owner[postalCode]" => '25200',
            "owner[city]" => 'Paris',
            "project[firstName]" => 'firstName',
            "project[lastName]" => 'lastName',
            "project[company]" => 'company',
            "project[address]" => 'address',
            "project[postalCode]" => 'postalCode',
            "project[city]" => "city",
            "project[phoneNumber]" => "phoneNumber",
            "project[email]" => "test@gmail.com",
            "project[masterJob]" => "ARCHITECTE",
            "project[projectType]" => "CONSTRUCTION",
            "project[cadastralReference]" => "De 0 à 400m",
            "project[projectLocation]" => "RASE CAMPAGNE",
            "project[constructionPlanDate][day]" => 01,
            "project[constructionPlanDate][month]" => 01,
            "project[constructionPlanDate][year]" => 2018,
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame("homePage");
    }

    public function testCreateProjectWithLoggedAccount(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('project_create'));
        $client->followRedirect();
        self::assertRouteSame('security_login');
    }

}