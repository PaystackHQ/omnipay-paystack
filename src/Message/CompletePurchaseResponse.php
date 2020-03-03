<?php

namespace Omnipay\Paystack\Message;

class CompletePurchaseResponse extends \Omnipay\Common\Message\AbstractResponse
{
    
    public function isSuccessful()
    {
        return 'success' === $this->getCode();
    }

    
    public function getTransactionId()
    {
        return $this->data['id'];
    }

    
    public function getTransactionReference()
    {
        return $this->data['reference'];
    }

    
    public function getCode()
    {
        return $this->data['status'];
    }
}