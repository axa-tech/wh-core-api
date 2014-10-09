<?php

namespace Axa\Bundle\WhapiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationControllerTest extends WebTestCase
{
    public function testPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/applications');
    }

}
