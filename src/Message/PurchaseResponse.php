<?php

namespace Omnipay\Paystack\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->data['authorization_url'];
    }

    public function getRedirectData()
    {
        return $this->data;
    }

    public function getRedirectMethod() 
    {
        return "GET"
    }

    public function getCode()
    {
        return $this->data['access_code'];
    }

    public function getTransactionReference()
    {
        return $this->data['reference'];
    }
}
