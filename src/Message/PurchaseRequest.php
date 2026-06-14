<?php

declare(strict_types=1);

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseRequest extends AbstractRequest
{
    public function getApiEndpoint(): string
    {
        return '/transaction/initialize';
    }

    public function getData(): array
    {
        $this->validate('amount', 'email');

        return [
            'amount' => $this->getAmountInteger(),
            'currency' => $this->getCurrency(),
            'email' => $this->getParameter('email'),
            'reference' => $this->getTransactionReference(),
            'callback_url' => $this->getReturnUrl(),
            'metadata' => $this->getParameter('metadata'),
        ];
    }

    public function sendData($data): ResponseInterface
    {
        try {
            $response = $this->sendRequest('POST', $this->getApiEndpoint(), $data);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), (int) $e->getCode(), $e);
        }

        return $this->response = new PurchaseResponse($this, $response ?? []);
    }

    public function setEmail(mixed $email): static
    {
        return $this->setParameter('email', $email);
    }
}
