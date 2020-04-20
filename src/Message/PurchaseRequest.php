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
     * {@inheritdoc}
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

            // TODO: Move to omnipay's httpClient e.g:
            //$headers = [
            //  'Authorization' => 'Bearer ' . $this->getSecretKey()
            //];
            //$httpResponse = $this->httpClient->request('POST', $this->getEndpoint(), $headers, json_encode($data));

            $secret_key = $this->getParameter('secret_key');

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $this->getApiEndpoint(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer $secret_key",
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ]);

            $response = curl_exec($curl);

            $responseData = json_decode($response, true);
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
