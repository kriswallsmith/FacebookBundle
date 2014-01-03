<?php

namespace FOS\FacebookBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FacebookControllerTest extends WebTestCase
{
    public function testChannelAction()
    {
        $client = static::createClient();
        $client->request('GET', '/channel.html');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $maxAge = static::$kernel->getContainer()->getParameter('fos_facebook.channel.expire');
        $this->assertEquals($maxAge, $response->getMaxAge());
    }
}