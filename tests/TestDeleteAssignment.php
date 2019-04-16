<?php
namespace tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestDeleteAssignment extends WebTestCase
{

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('DELETE', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    public function urlProvider()
    {
        yield ['/assignments/18/10'];
    }

}