<?php

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getApiEndpoint()
    {
        return $this->baseApiEndpoint . 'transaction/verify/' . rawurlencode($this->getTransactionReference());
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $this->getSecretKey(),
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache'
            ];

            $response = $this->httpClient->request('GET', $this->getApiEndpoint(), $headers, json_encode($data));
            $responseData = json_decode((string)$response->getBody(), true);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->response = new CompletePurchaseResponse($this, $responseData);
    }
}