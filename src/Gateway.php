<?php

namespace Omnipay\Paystack;

use Omnipay\Common\AbstractGateway;
use Omnipay\Paystack\Message\CompletePurchaseRequest;
use Omnipay\Paystack\Message\PurchaseRequest;
use Omnipay\Paystack\Message\RefundRequest;

/**
 * PayStack Gateway
 *
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Paystack';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'secret_key' => '',
            'public_key' => '',
        ];
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->getParameter('secret_key');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secret_key', $value);
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->getParameter('public_key');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setPublicKey($value)
    {
        return $this->setParameter('public_key', $value);
    }

    /**
     * @inheritDoc
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }
}
