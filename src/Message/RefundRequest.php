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
            $response = $this->sendRequest('POST', $this->getApiEndpoint(), $data);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->response = new RefundResponse($this, $response);
    }
}
