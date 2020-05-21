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

            $response = $this->sendRequest('GET', $this->getApiEndpoint(), json_encode($data));

        } catch (\Exception $e) {
            
            throw new InvalidRequestException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->response = new CompletePurchaseResponse($this, $responseData);
    }
}