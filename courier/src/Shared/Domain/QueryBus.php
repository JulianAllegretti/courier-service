<?php

namespace App\Shared\Domain;

use Symfony\Component\HttpFoundation\Response;

interface QueryBus
{
    public function ask(Query $query): ?Response;
}