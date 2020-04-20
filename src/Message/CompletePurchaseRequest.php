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
        return $this->baseApiEndpoint . 'transaction/verify/';
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
        $secret_key = $this->getSecretKey();

        try {
            $curl = curl_init();
            $url = $this->getApiEndpoint() . rawurlencode($this->getTransactionReference());

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer " . $secret_key,
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ]);

            $response = curl_exec($curl);

            $responseData = json_decode($response, true);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->response = new CompletePurchaseResponse($this, $responseData);
    }
}