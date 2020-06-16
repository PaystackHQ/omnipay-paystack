<?php

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getApiEndpoint()
    {
        return $this->baseApiEndpoint . '/refund';
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $amount = $this->getAmountInteger();
        $reference = $this->getTransactionReference();

        $data = ['transaction' => $reference];

        if ($amount) {
            $data['amount'] = $amount;
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

        return $this->response = new RefundResponse($this, $responseData);
    }
}
