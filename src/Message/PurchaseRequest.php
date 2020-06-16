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
        return '/transaction/initialize';
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('amount', 'email');

        $amount = $this->getAmountInteger();
        $email = $this->getParameter('email');

        return [
            'amount' => $amount,
            'currency' => $this->getCurrency(),
            'email' => $email,
            'reference' => $this->getTransactionReference(),
            'callback_url' => $this->getReturnUrl(),
            'metadata' => $this->getParameter('metadata')
        ];
    }

    /**
     * @inheritdoc
     */
    public function sendData($data)
    {
        try {
            $response = $this->sendRequest('POST', $this->getApiEndpoint(), $data);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->response = new PurchaseResponse($this, $response);
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
