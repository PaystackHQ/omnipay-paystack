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

    /**
     * {@inheritdoc}
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectUrl()
    {
        return $this->data['authorization_url'];
    }

    public function getRedirectData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessCode()
    {
        return $this->data->access_code;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionReference()
    {
        return $this->data->reference;
    }
}
