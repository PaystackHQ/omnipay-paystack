<?php

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Exception\BadMethodCallException;
use Omnipay\Common\Exception\InvalidRequestException;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $baseApiEndpoint = 'https://api.paystack.co/';

    /**
     * @return string The URL endpoint for the request
     * @throws InvalidRequestException
     */
    public function getApiEndpoint()
    {
        throw new InvalidRequestException('Api endpoint not implemented');
    }

    public function getPublicKey()
    {
        return $this->getParameter('public_key');
    }

    public function setPublicKey($value)
    {
        $this->setParameter('public_key', $value);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secret_key');
    }

    public function setSecretKey($value)
    {
        $this->setParameter('secret_key', $value);
    }
}
