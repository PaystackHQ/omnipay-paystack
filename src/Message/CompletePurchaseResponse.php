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
            if ($data['reference']) {
                return $data['reference'];
            }
        }
    }

    public function getMessage()
    {
        if (isset($this->data['data']) && $data = $this->data['data']) {
            if ($data['message']) {
                return $data['message'];
            }
        }

        if (isset($this->data['data']) && $data = $this->data['data']) {
            if ($data['gateway_response']) {
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
            return $data['reference'];
        }

        return '';
    }


    public function getCode()
    {
        if (isset($this->data['data']) && $data = $this->data['data']) {
            return $data['status'];
        }

        return '';
    }
}