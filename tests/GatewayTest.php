<?php

namespace Omnipay\PayStack\Tests;

use Omnipay\Paystack\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{

    const PURCHASE_REFERENCE = '8c3fd38b98936a4c04bd9e20f8247b97';

    /** @var Gateway */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = [
            'amount' => '100',
            'email' => 'email@email.com',
            'reference' => static::PURCHASE_REFERENCE
        ];
    }

    public function testPurchase()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->purchase($this->options)->send();

        $this->assertTrue($response->isRedirect(), 'Purchase response is a redirect');
        $this->assertEquals(static::PURCHASE_REFERENCE, $response->getTransactionReference(), 'Reference is as we gave it.');
        $this->assertEquals('Authorization URL created', $response->getMessage());
    }
}
