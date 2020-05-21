<?php

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getApiEndpoint()
    {
        return $this->baseApiEndpoint . '/transaction/initialize/';
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('amount', 'email');

        $amount = $this->getAmountInteger();
        $email = $this->getParameter('email');
        $reference = $this->getTransactionReference();

        return [
            'amount' => $amount,
            'email' => $email,
            'callback_url' => $this->getReturnUrl(),
            'reference' => $reference
        ];
    }

    /**
     * @inheritdoc
     */
    public function sendData($data)
    {
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $this->getSecretKey(),
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache'
            ];

            $response = $this->httpClient->request('POST', $this->getApiEndpoint(), $headers, json_encode($data));
            $responseData = json_decode((string)$response->getBody(), true);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->response = new PurchaseResponse($this, $responseData);
    }

    /**
     * Sets the email parameter.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setParameter('email', $email);
    }
}
