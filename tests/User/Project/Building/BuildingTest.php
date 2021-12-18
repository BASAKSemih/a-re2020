<?php

namespace App\Tests\User\Project\Building;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class BuildingTest extends WebTestCase
{
    public function testCreateProjectForBuilding(): void
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
        $form = $crawler->filter('form[name=owner]')->form([
            'owner[lastName]' => 'lastName',
            'owner[firstName]' => 'firstName',
            'owner[address]' => '21 rue Chamvalon',
            'owner[postalCode]' => '25200',
            'owner[city]' => 'Paris',
            'project[firstName]' => 'firstName',
            'project[lastName]' => 'lastName',
            'project[company]' => 'sdsdsdsdsd',
            'project[address]' => 'address',
            'project[postalCode]' => 'postalCode',
            'project[city]' => 'city',
            'project[phoneNumber]' => 'phoneNumber',
            'project[email]' => 'test@build.com',
            'project[masterJob]' => 'ARCHITECTE',
            'project[projectType]' => 'CONSTRUCTION',
            'project[cadastralReference]' => 'De 0 à 400m',
            'project[projectLocation]' => 'RASE CAMPAGNE',
            'project[constructionPlanDate][day]' => 01,
            'project[constructionPlanDate][month]' => 01,
            'project[constructionPlanDate][year]' => 2018,
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }

    public function testCreateProjectForBuildingData(): void
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
        $form = $crawler->filter('form[name=owner]')->form([
            'owner[lastName]' => 'forbuildingfail',
            'owner[firstName]' => 'forbuildingfail',
            'owner[address]' => '21 rue forbuildingfail',
            'owner[postalCode]' => '25200',
            'owner[city]' => 'Paris',
            'project[firstName]' => 'forbuildingfail',
            'project[lastName]' => 'forbuildingfail',
            'project[company]' => 'forbuildingfailsss',
            'project[address]' => 'address',
            'project[postalCode]' => 'postalCode',
            'project[city]' => 'city',
            'project[phoneNumber]' => 'phoneNumber',
            'project[email]' => 'test@build.com',
            'project[masterJob]' => 'ARCHITECTE',
            'project[projectType]' => 'CONSTRUCTION',
            'project[cadastralReference]' => 'De 0 à 400m',
            'project[projectLocation]' => 'RASE CAMPAGNE',
            'project[constructionPlanDate][day]' => 01,
            'project[constructionPlanDate][month]' => 01,
            'project[constructionPlanDate][year]' => 2018,
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }

    public function testCreateBuilding(): void
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
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('sdsdsdsdsd');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('building_create', [
            'idProject' => $project->getId()
        ]));
        self::assertRouteSame('building_create');
        $form = $crawler->filter('form[name=building]')->form([
            'building[floorArea]' => 'floorArea',
            'building[livingArea]' => 'livingArea',
            'building[existingFloorArea]' => 'existingFloorArea',
            'building[lowFloor]' => 'lowFloor',
            'building[lowFloorThermal]' => 'Avec planelle',
            'building[highFloor]' => 'highFloor',
            'building[highFloorThermal]' => 'Avec planelle',
            'building[intermediateFloor]' => 'intermediateFloor',
            'building[intermediateFloorThermal]' => 'Avec planelle',
            'building[facades]' => 'facades',
            'building[particularWalls]' => 'particularWalls',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }

    /**
     * @dataProvider provideFailedData
     */
    public function testCreateBuildingFailedData(array $formData): void
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
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('forbuildingfailsss');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('building_create', [
            'idProject' => $project->getId()
        ]));
        self::assertRouteSame('building_create');
        $form = $crawler->filter('form[name=building]')->form($formData);
        $client->submit($form);
    }

    public function provideFailedData(): iterable
    {
        $baseData = static fn (array $data) => $data + [
                'building[floorArea]' => 'providefaildata',
                'building[livingArea]' => 'providefaildata',
                'building[existingFloorArea]' => 'providefaildata',
                'building[lowFloor]' => 'providefaildata',
                'building[lowFloorThermal]' => 'Avec planelle',
                'building[highFloor]' => 'providefaildata',
                'building[highFloorThermal]' => 'Avec planelle',
                'building[intermediateFloor]' => 'intermediateFloor',
                'building[intermediateFloorThermal]' => 'Avec planelle',
                'building[facades]' => 'providefaildata',
                'building[particularWalls]' => 'providefaildata',
            ];

        yield 'floorArea is empty' => [$baseData(['building[floorArea]' => ''])];
        yield 'livingArea is empty' => [$baseData(['building[livingArea]' => ''])];
        yield 'existingFloorArea is empty' => [$baseData(['building[existingFloorArea]' => ''])];
        yield 'lowFloor is empty' => [$baseData(['building[lowFloor]' => ''])];
        yield 'highFloor is empty' => [$baseData(['building[highFloor]' => ''])];
        yield 'intermediateFloor is empty' => [$baseData(['building[intermediateFloor]' => ''])];
        yield 'facades is empty' => [$baseData(['building[facades]' => ''])];
        yield 'particularWalls is empty' => [$baseData(['building[particularWalls]' => ''])];
    }

    public function testEditBuilding(): void
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
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('sdsdsdsdsd');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('building_edit', [
            'idProject' => $project->getId()
        ]));
        self::assertRouteSame('building_edit');
        $form = $crawler->filter('form[name=building]')->form([
            'building[floorArea]' => 'edited',
            'building[livingArea]' => 'edited',
            'building[existingFloorArea]' => 'edited',
            'building[lowFloor]' => 'edited',
            'building[lowFloorThermal]' => 'Avec planelle',
            'building[highFloor]' => 'edited',
            'building[highFloorThermal]' => 'Avec planelle',
            'building[intermediateFloor]' => 'edited',
            'building[intermediateFloorThermal]' => 'Avec planelle',
            'building[facades]' => 'edited',
            'building[particularWalls]' => 'edited',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }

    /**
     * @dataProvider provideFailedData
     */
    public function testEditBuildingFailedData(array $formData): void
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
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");
        $projectRepository = $entityManager->getRepository(Project::class);
        /** @var Project $project */
        $project = $projectRepository->findOneByCompany('sdsdsdsdsd');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('building_edit', [
            'idProject' => $project->getId()
        ]));
        self::assertRouteSame('building_edit');
        $form = $crawler->filter('form[name=building]')->form($formData);
        $client->submit($form);
    }

}