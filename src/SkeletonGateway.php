<?php

namespace Omnipay\Skeleton;

use Omnipay\Common\AbstractGateway;

/**
 * Skeleton Gateway
 */
class SkeletonGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Paystack';
    }

    public function getDefaultParameters()
    {
        return array(
            'secret_key' => '',
            'public_key' => '',
            'callback_url' => ''
        );
    }

    public function getSecretKey()
    {
        return $this->getParameter('secret_key');
    }

    public function setSecretKey($value)
    {
        return $this->setParameter('secret_key', $value);
    }

    public function getPublicKey()
    {
        return $this->getParameter('public_key');
    }

    public function setPublicKey($value)
    {
        return $this->setParameter('public_key', $value);
    }

    /**
     * @return Message\AuthorizeRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Skeleton\Message\AuthorizeRequest', $parameters);
    }
}
