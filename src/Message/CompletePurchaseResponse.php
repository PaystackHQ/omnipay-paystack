<?php

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{

    public function isSuccessful()
    {
        return 'success' === $this->getCode();
    }

    public function getTransactionId()
    {
        if (isset($this->data['data']) && $data = $this->data['data']) {
            if (!empty($data['reference'])) {
                return $data['reference'];
            }
        }
    }

    public function getMessage()
    {
        if (isset($this->data['data']) && $data = $this->data['data']) {
            if (!empty($data['message'])) {
                return $data['message'];
            }
        }

        if (isset($this->data['data']) && $data = $this->data['data']) {
            if (!empty($data['gateway_response'])) {
                return $data['gateway_response'];
            }
        }

        if (isset($this->data['message']) && $message = $this->data['message']) {
            return $message;
        }

        return '';
    }

    public function getTransactionReference()
    {
        if (isset($this->data['data']) && $data = $this->data['data']) {
            return $data['reference'] ?? null;
        }

        return '';
    }


    public function getCode()
    {
        if (isset($this->data['data']) && $data = $this->data['data']) {
            return $data['status'] ?? null;
        }

        return '';
    }
}
