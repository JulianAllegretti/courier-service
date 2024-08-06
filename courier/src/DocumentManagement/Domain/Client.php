<?php

namespace App\DocumentManagement\Domain;

interface Client
{
    function get(string $url, string $method, array $body);
}