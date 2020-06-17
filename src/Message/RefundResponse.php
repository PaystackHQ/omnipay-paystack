<?php

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Message\AbstractResponse;

class RefundResponse extends AbstractResponse
{

    public function isSuccessful()
    {

        if (isset($this->data['data']) && $transaction = $this->data['data']['transaction']) {
            if (isset($transaction['status']) && $transaction['status'] == 'reversed') {
                return true;
            }
        }

        return false;
    }

    public function isRedirect()
    {
        return false;
    }

    public function getMessage()
    {
        if (isset($this->data['message']) && $message = $this->data['message']) {
            return $message;
        }

        return '';
    }

    public function getCode()
    {
        if (isset($this->data['data']) && $data = $this->data['data']) {
            return $data['access_code'];
        }

        return '';
    }

    public function getTransactionReference()
    {
        if (isset($this->data['data']) && $data = $this->data['data']) {
            if (isset($data['transaction']) && $transaction = $data['transaction']) {
                return $transaction['reference'];
            }
        }

        return '';
    }
}
