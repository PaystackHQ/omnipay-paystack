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

        $data = [
            'amount' => $amount,
            'email' => $email,
            'callback_url' => $this->getReturnUrl(),
            'metadata' => $this->getParameter('metadata')
        ];

        if ($reference = $this->getTransactionReference()) {
            $data['reference'] = $reference;
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function sendData($data)
    {
        try {
            $response = $this->httpClient->request('POST', $this->getApiEndpoint(), $this->getRequestHeaders(), json_encode($data));
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
