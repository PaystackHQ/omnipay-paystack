<?php

declare(strict_types=1);

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful(): bool
    {
        return false;
    }

    public function isRedirect(): bool
    {
        return isset($this->data['status'])
            && $this->data['status'] === true
            && $this->getRedirectUrl() !== '';
    }

    public function getRedirectUrl(): string
    {
        if (isset($this->data['data']) && is_array($this->data['data'])) {
            return (string) ($this->data['data']['authorization_url'] ?? '');
        }

        return '';
    }

    public function getMessage(): string
    {
        if (isset($this->data['message'])) {
            return (string) $this->data['message'];
        }

        return '';
    }

    public function getRedirectData(): array
    {
        return [];
    }

    public function getRedirectMethod(): string
    {
        return 'GET';
    }

    public function getCode(): string
    {
        if (isset($this->data['data']) && is_array($this->data['data'])) {
            return (string) ($this->data['data']['access_code'] ?? '');
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
}
