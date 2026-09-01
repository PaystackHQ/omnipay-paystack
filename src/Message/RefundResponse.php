<?php

declare(strict_types=1);

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Message\AbstractResponse;

class RefundResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        if (isset($this->data['data']['transaction']) && is_array($this->data['data']['transaction'])) {
            return ($this->data['data']['transaction']['status'] ?? null) === 'reversed';
        }

        return false;
    }

    public function isRedirect(): bool
    {
        return false;
    }

    public function getMessage(): string
    {
        if (isset($this->data['message'])) {
            return (string) $this->data['message'];
        }

        return '';
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
        if (isset($this->data['data']['transaction']) && is_array($this->data['data']['transaction'])) {
            return (string) ($this->data['data']['transaction']['reference'] ?? '');
        }

        return '';
    }
}
