<?php

namespace App\Shared\Domain;

interface Log
{
    function getDecodedRequest() : mixed;

    function getDecodedError() : mixed;
}