<?php

namespace Omnipay\PayStack\Tests;

use Omnipay\Paystack\Gateway;
use Omnipay\Paystack\Message\CompletePurchaseResponse;
use Omnipay\Paystack\Message\PurchaseResponse;
use Omnipay\Paystack\Message\RefundResponse;
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
    public function setUp(): void
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

    /**
     *
     */
    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');

        $response = $this->gateway->purchase(array_merge($this->options, [
            'email' => 'email@email.com'
        ]))->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Invalid key', $response->getMessage());
        $this->assertSame('', $response->getRedirectUrl());
        $this->assertSame('', $response->getTransactionReference());
    }

    /**
     *
     */
    public function testRefundFailure()
    {
        $this->setMockHttpResponse('RefundFailure.txt');

        $response = $this->gateway->refund($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('Transaction has been fully reversed', $response->getMessage());
        $this->assertSame('', $response->getTransactionReference());
    }

    /**
     *
     */
    public function testCompletePurchaseSuccess()
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');

        $response = $this->gateway->completePurchase(['transactionReference' => '0rujfjycxi'])->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('success', $response->getCode());
        $this->assertSame('0rujfjycxi', $response->getTransactionReference());
        $this->assertSame('Successful', $response->getMessage());
    }

    /**
     *
     */
    public function testCompletePurchaseFailure()
    {
        $this->setMockHttpResponse('CompletePurchaseFailure.txt');

        $response = $this->gateway->completePurchase(['transactionReference' => '0rujfjycxj'])->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('failed', $response->getCode());
        $this->assertSame('Declined', $response->getMessage());
    }

    /**
     *
     */
    public function testCompletePurchaseReferenceNotFound()
    {
        $this->setMockHttpResponse('CompletePurchaseNotFound.txt');

        $response = $this->gateway->completePurchase(['transactionReference' => 'unknown'])->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('Transaction reference not found', $response->getMessage());
        $this->assertSame('', $response->getTransactionReference());
    }

    /**
     *
     */
    public function testCompletePurchaseWithoutReference()
    {
        $this->setMockHttpResponse('CompletePurchaseNotFound.txt');

        $response = $this->gateway->completePurchase()->send();

        $this->assertFalse($response->isSuccessful());
    }

    /**
     * A payload missing optional keys must not raise warnings on PHP 8.
     */
    public function testCompletePurchasePartialPayload()
    {
        $request = $this->gateway->completePurchase(['transactionReference' => 'abc']);
        $response = new CompletePurchaseResponse($request, ['status' => true, 'data' => ['status' => 'abandoned']]);

        $this->assertFalse($response->isSuccessful());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('', $response->getMessage());
    }

    /**
     * A payload missing optional keys must not raise warnings on PHP 8.
     */
    public function testPurchaseAndRefundPartialPayload()
    {
        $purchase = new PurchaseResponse($this->gateway->purchase(), ['status' => true, 'data' => ['id' => 1]]);

        $this->assertFalse($purchase->isRedirect());
        $this->assertNull($purchase->getRedirectUrl());
        $this->assertNull($purchase->getCode());
        $this->assertNull($purchase->getTransactionReference());

        $refund = new RefundResponse($this->gateway->refund(), ['status' => true, 'data' => ['id' => 1]]);

        $this->assertFalse($refund->isSuccessful());
        $this->assertNull($refund->getCode());
        $this->assertSame('', $refund->getTransactionReference());
    }
}
