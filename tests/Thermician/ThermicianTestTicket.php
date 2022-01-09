<?php

namespace App\Tests\Thermician;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class ThermicianTestTicket extends WebTestCase
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


}