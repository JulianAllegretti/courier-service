<?php

namespace App\Shared\Domain\ValueObjects;

interface ValueObject
{
    function init(): void;
    function getValue(): mixed;
}