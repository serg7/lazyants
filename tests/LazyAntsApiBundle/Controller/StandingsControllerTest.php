<?php

namespace LazyAnts\Bundle\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StandingsControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/standings');

        // Check api response headers
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $client->getResponse()->headers->get('Content-Type'));

        // Check content
        $content = json_decode(json_decode($client->getResponse()->getContent()), true);

        $this->assertArrayHasKey('place', $content[0]);
        $this->assertInternalType("int", $content[0]['place']);
        $this->assertTrue($content[0]['place'] <= 20);

        $this->assertArrayHasKey('team', $content[0]);
        $this->assertInternalType('string', $content[0]['team']);
        $this->assertRegExp('/^[a-zA-Z ]{3,15}$/', $content[0]['team']);

        $this->assertArrayHasKey('played', $content[0]);
        $this->assertInternalType('int', $content[0]['played']);
        $this->assertTrue($content[0]['played'] <= 38);

        $this->assertArrayHasKey('wins', $content[0]);
        $this->assertInternalType('int', $content[0]['wins']);
        $this->assertTrue($content[0]['wins'] <= 38);

        $this->assertArrayHasKey('draws', $content[0]);
        $this->assertInternalType('int', $content[0]['draws']);
        $this->assertTrue($content[0]['draws'] <= 38);

        $this->assertArrayHasKey('losses', $content[0]);
        $this->assertInternalType('int', $content[0]['losses']);
        $this->assertTrue($content[0]['losses'] <= 38);

        $this->assertArrayHasKey('points', $content[0]);
        $this->assertInternalType('int', $content[0]['points']);
        $this->assertTrue($content[0]['points'] <= 114);


        // check cases when we have valid/invalid 'to' and 'from' params
        // first case: normal
        $crawler = $client->request('GET', '/api/standings?from=2012-01-05&to=2012-2-5');
        $this->assertContains('');


    }
}
