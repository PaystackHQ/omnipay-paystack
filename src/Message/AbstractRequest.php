<?php

declare(strict_types=1);

namespace Omnipay\Paystack\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    protected string $baseApiEndpoint = 'https://api.paystack.co';

    public function getApiEndpoint(): string
    {
        throw new InvalidRequestException('Api endpoint not implemented');
    }

    public function getPublicKey(): mixed
    {
        return $this->getParameter('public_key');
    }

    public function setPublicKey(mixed $value): static
    {
        return $this->setParameter('public_key', $value);
    }

    public function getSecretKey(): mixed
    {
        return $this->getParameter('secret_key');
    }

    public function setSecretKey(mixed $value): static
    {
        return $this->setParameter('secret_key', $value);
    }

    /**
     * @param  array<string, mixed>|null  $data
     * @return array<string, mixed>|null
     */
    protected function sendRequest(string $method, string $endpoint, ?array $data = null): ?array
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->getSecretKey(),
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache',
        ];

        $url = $this->baseApiEndpoint.$endpoint;
        $body = $data === null || $data === [] ? null : json_encode($data);

        /** @var ResponseInterface $response */
        $response = $this->httpClient->request(
            $method,
            $url,
            $headers,
            $body
        );

        $responseData = json_decode((string) $response->getBody(), true);

        return is_array($responseData) ? $responseData : null;
    }
}
