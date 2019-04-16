<?php


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestAddAssignment extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('POST', $url,['user_id'=>18,'group_id'=>10]);
        $this->assertTrue($client->getResponse()->isSuccessful());    }

    public function urlProvider()
    {
        yield ['/assignments'];
    }
}