<?php

declare(strict_types=1);

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getApiEndpoint(): string
    {
        return '/transaction/verify/'.rawurlencode((string) $this->getTransactionReference());
    }

    public function getData(): array
    {
        return [];
    }

    public function sendData($data): ResponseInterface
    {
        try {
            $response = $this->sendRequest('GET', $this->getApiEndpoint());
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), (int) $e->getCode(), $e);
        }

        return $this->response = new CompletePurchaseResponse($this, $response ?? []);
    }
}
