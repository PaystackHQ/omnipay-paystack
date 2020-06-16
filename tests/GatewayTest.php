<?php

namespace Omnipay\PayStack\Tests;

use Omnipay\Paystack\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{

    const PURCHASE_REFERENCE = '8c3fd38b98936a4c04bd9e20f8247b97';

    /** @var Gateway */
    protected $gateway;

    /** @var array */
    protected $options;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = [
            'amount' => '2500',
            'reference' => static::PURCHASE_REFERENCE
        ];
    }

    /**
     *
     */
    public function testPurchase()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $options = array_merge($this->options, [
            'email' => 'email@email.com'
        ]);

        $response = $this->gateway->purchase($options)->send();

        $this->assertTrue($response->isRedirect(), 'Purchase response is a redirect');
        $this->assertEquals(
            static::PURCHASE_REFERENCE,
            $response->getTransactionReference(),
            'Reference is as we gave it.'
        );
        $this->assertEquals('Authorization URL created', $response->getMessage());
    }

    /**
     *
     */
    public function testRefund()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');

        $options = array_merge($this->options, [
            'reference' => static::PURCHASE_REFERENCE
        ]);

        $response = $this->gateway->refund($options)->send();

        $this->assertTrue($response->isSuccessful(), 'Refund is successful status');
        $this->assertEquals(static::PURCHASE_REFERENCE, $response->getTransactionReference(), 'Reference is as we gave it');
    }
}
