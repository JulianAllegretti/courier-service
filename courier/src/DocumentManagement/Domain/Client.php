<?php

namespace App\DocumentManagement\Domain;

interface Client
{
    function get(array $data): void;
}