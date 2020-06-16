<?php

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Exception\InvalidRequestException;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $baseApiEndpoint = 'https://api.paystack.co';

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

    protected function sendRequest($method, $endpoint, array $data = null)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->getSecretKey(),
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache'
        ];

        $url = $this->baseApiEndpoint . $endpoint;
        $response = $this->httpClient->request(
            $method,
            $url,
            $headers,
            json_encode($data)
        );
        $responseData = json_decode((string)$response->getBody(), true);

        return $responseData;
    }
}
