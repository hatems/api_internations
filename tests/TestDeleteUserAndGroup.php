<?php
namespace tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestDeleteUserAndGroup extends WebTestCase
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
        yield ['/groups/1'];
        yield ['/users/1'];
    }

}