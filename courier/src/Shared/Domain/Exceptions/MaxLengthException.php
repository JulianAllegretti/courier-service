<?php

namespace App\Shared\Domain\Exceptions;

class MaxLengthException extends \Exception
{
    protected $code = 'C-E-300';
}