<?php

namespace App\DocumentManagement\Application\Interfaces;

interface IApiHTTPClient
{
    public function post(string $url, mixed $client): string;
}