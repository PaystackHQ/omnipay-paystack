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
        return '/refund';
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $data = [];
        $data['transaction'] = $this->getTransactionReference();
        $data['currency'] = $this->getCurrency();

        if ($this->getAmountInteger()) {
            $data['amount'] = $this->getAmountInteger();
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
