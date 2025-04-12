<?php

namespace App\DocumentManagement\Infrastructure\ExternalAPI;

use App\DocumentManagement\Application\Interfaces\IApiHTTPClient;
use App\DocumentManagement\Infrastructure\Serializer\UppercaseFirstLetterNameConverter;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiHTTP472Client implements IApiHTTPClient
{
    private HttpClientInterface $httpClient;
    private Serializer $serializer;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $normalizer = new ObjectNormalizer(null, new UppercaseFirstLetterNameConverter());
        $this->serializer = new Serializer([$normalizer], [new JsonEncoder()]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function post(string $url, mixed $client): string
    {
        $json = $this->serializer->serialize($client, 'json');

        $response = $this->httpClient->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $json,
        ]);

        return $response->getContent();
    }
}