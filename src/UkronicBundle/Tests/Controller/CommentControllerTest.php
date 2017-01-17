<?php

namespace UkronicBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testLike()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/comment/like/{id}/{userId}');
    }

}
