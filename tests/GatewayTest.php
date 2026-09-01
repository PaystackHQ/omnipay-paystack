<?php

declare(strict_types=1);

namespace Omnipay\Paystack\Test;

use Omnipay\Paystack\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    private const PURCHASE_REFERENCE = '8c3fd38b98936a4c04bd9e20f8247b97';

    /** @var Gateway */
    protected $gateway;

    /** @var array<string, mixed> */
    protected array $options;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = [
            'amount' => '2500',
            'reference' => self::PURCHASE_REFERENCE,
        ];
    }

    public function testPurchase(): void
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $options = array_merge($this->options, [
            'email' => 'email@email.com',
        ]);

        $response = $this->gateway->purchase($options)->send();

        $this->assertTrue($response->isRedirect(), 'Purchase response is a redirect');
        $this->assertSame(
            self::PURCHASE_REFERENCE,
            $response->getTransactionReference(),
            'Reference is as we gave it.'
        );
        $this->assertSame('Authorization URL created', $response->getMessage());
    }

    public function testCompletePurchase(): void
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');

        $response = $this->gateway->completePurchase([
            'reference' => self::PURCHASE_REFERENCE,
        ])->send();

        $this->assertTrue($response->isSuccessful(), 'Complete purchase is successful');
        $this->assertSame('0rujfjycxi', $response->getTransactionReference());
    }

    public function testRefund(): void
    {
        $this->setMockHttpResponse('RefundSuccess.txt');

        $options = array_merge($this->options, [
            'reference' => self::PURCHASE_REFERENCE,
        ]);

        $response = $this->gateway->refund($options)->send();

        $this->assertTrue($response->isSuccessful(), 'Refund is successful status');
        $this->assertSame(self::PURCHASE_REFERENCE, $response->getTransactionReference(), 'Reference is as we gave it');
    }
}
