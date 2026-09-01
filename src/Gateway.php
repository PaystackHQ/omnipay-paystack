<?php

declare(strict_types=1);

namespace Omnipay\Paystack;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Paystack\Message\CompletePurchaseRequest;
use Omnipay\Paystack\Message\PurchaseRequest;
use Omnipay\Paystack\Message\RefundRequest;

class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'Paystack';
    }

    public function getDefaultParameters(): array
    {
        return [
            'secret_key' => '',
            'public_key' => '',
        ];
    }

    public function getSecretKey(): mixed
    {
        return $this->getParameter('secret_key');
    }

    public function setSecretKey(mixed $value): static
    {
        return $this->setParameter('secret_key', $value);
    }

    public function getPublicKey(): mixed
    {
        return $this->getParameter('public_key');
    }

    public function setPublicKey(mixed $value): static
    {
        return $this->setParameter('public_key', $value);
    }

    public function purchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    public function refund(array $parameters = []): RequestInterface
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }
}
