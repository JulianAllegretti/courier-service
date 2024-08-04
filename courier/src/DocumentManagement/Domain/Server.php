<?php

namespace App\DocumentManagement\Domain;


use Symfony\Component\HttpFoundation\Response;

interface Server
{
    public function render(array $data): Response;
}