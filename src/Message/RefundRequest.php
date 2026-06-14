<?php

declare(strict_types=1);

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

class RefundRequest extends AbstractRequest
{
    public function getApiEndpoint(): string
    {
        return '/refund';
    }

    public function getData(): array
    {
        $data = [
            'transaction' => $this->getTransactionReference(),
            'currency' => $this->getCurrency(),
        ];

        if ($this->getAmountInteger()) {
            $data['amount'] = $this->getAmountInteger();
        }

        return $data;
    }

    public function sendData($data): ResponseInterface
    {
        try {
            $response = $this->sendRequest('POST', $this->getApiEndpoint(), $data);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), (int) $e->getCode(), $e);
        }

        return $this->response = new RefundResponse($this, $response ?? []);
    }
}
