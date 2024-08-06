<?php

namespace App\DocumentManagement\Infrastructure;

use App\DocumentManagement\Domain\Client;
use SoapClient;

readonly class ClientSoap implements Client
{

    public function __construct()
    {
    }

    /**
     * @throws \SoapFault
     */
    function get(string $url, string $method, array $body)
    {
        $client = new SoapClient($url);
        $client->__setLocation($url);
        $response = $client->__soapCall($method, $body);
        return $response;
    }
}