<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ConversionControllerTest extends WebTestCase
{
    public function testConvertECB()
    {
        $client = static::createClient();

        $date = new \DateTime();
        $data = [
            'date' => $date->format('Y-m-d'),
            'amount' => '10.00',
            'currencySell' => 'EUR',
            'currencyBuy' => 'USD',
        ];
        $client->request('POST', '/convert_currency/ECB/', $data);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertNotEmpty($client->getResponse()->getContent());
        $this->assertSame('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertEquals('{"valid":true,"amount":"11.05","currency":"USD","message":""}', $client->getResponse()->getContent());
    }
}
