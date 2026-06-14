<?php

declare(strict_types=1);

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->getCode() === 'success';
    }

    public function getTransactionId(): ?string
    {
        if (isset($this->data['data']) && is_array($this->data['data'])) {
            $reference = $this->data['data']['reference'] ?? null;

            return is_string($reference) && $reference !== '' ? $reference : null;
        }

        return null;
    }

    public function getMessage(): string
    {
        if (isset($this->data['data']) && is_array($this->data['data'])) {
            $message = $this->data['data']['message'] ?? null;

            if (is_string($message) && $message !== '') {
                return $message;
            }

            $gatewayResponse = $this->data['data']['gateway_response'] ?? null;

            if (is_string($gatewayResponse) && $gatewayResponse !== '') {
                return $gatewayResponse;
            }
        }

        if (isset($this->data['message'])) {
            return (string) $this->data['message'];
        }

        return '';
    }

    public function getTransactionReference(): string
    {
        if (isset($this->data['data']) && is_array($this->data['data'])) {
            return (string) ($this->data['data']['reference'] ?? '');
        }

        return '';
    }

    public function getCode(): string
    {
        if (isset($this->data['data']) && is_array($this->data['data'])) {
            return (string) ($this->data['data']['status'] ?? '');
        }

        return '';
    }
}
