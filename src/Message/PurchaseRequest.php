<?php
namespace Omnipay\Paystack\Messages;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->validate('amount', 'email');
        $amount = $this->getAmount();

        return [
            'amount'       => $amount*100,
            'email'        => $this->getParameter('email'),
            'callback_url' => $this->getReturnUrl()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        try {

            $secret_key = $this->getParameter('secret_key');
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                  "authorization: Bearer $secret_key",
                  "content-type: application/json",
                  "cache-control: no-cache"
                ],
              ));
            
              $response = curl_exec($curl);

              $tranx = json_decode($response, true);
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->response = new PurchaseResponse($this, $tranx['data']);
    }

    /**
     * Sets the email parameter.
     *
     * @param  string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setParameter('email', $email);
    }
}
