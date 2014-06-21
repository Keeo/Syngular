<?php

namespace Syngular\BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonControllerTest extends WebTestCase
{
    public function testAll()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/people');

        $this->assertTrue($crawler->filter('html:contains("Karel")')->count() > 0);
    }
    
    /*public function testPost()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/people/',['name'=>'Karel']);

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }*/
    
    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('DELETE', '/people/', ['id'=>'12']);
    }
}
