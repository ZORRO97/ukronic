<?php

namespace UkronicBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SerieControllerTest extends WebTestCase
{
    public function testChoiceserie()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/choiceSerie');
    }

}
