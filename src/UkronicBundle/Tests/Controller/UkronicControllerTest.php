<?php

namespace UkronicBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UkronicControllerTest extends WebTestCase
{
    public function testRecherche()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Recherche');
    }

}
