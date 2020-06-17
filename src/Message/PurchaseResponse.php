<?php

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        if (isset($this->data['status']) && $this->data['status'] == true && $this->getRedirectUrl()) {
            return true;
        }

        return false;
    }

    public function getRedirectUrl()
    {
        if (isset($this->data['data']) && $data = $this->data['data']) {
            return $data['authorization_url'];
        }

        return '';
    }

    public function getMessage()
    {
        if (isset($this->data['message']) && $message = $this->data['message']) {
            return $message;
        }

        return '';
    }

    public function getRedirectData()
    {
        // Only required if the redirect method is POST
        return [];
    }

    public function getRedirectMethod()
    {
        return 'GET';
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
            return $data['reference'];
        }

        return '';
    }
}
