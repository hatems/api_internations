<?php


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestAddUserAndGroup extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('POST', $url,['name'=>'TestAdd']);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        yield ['/groups'];
        yield ['/users'];
    }
}