<?php

declare(strict_types=1);

namespace App\Tests\Home;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

final class HomeTest extends WebTestCase
{
    public function testShowHomePage(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('homePage'));
        self::assertRouteSame('homePage');
    }
}
