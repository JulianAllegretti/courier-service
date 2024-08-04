<?php

namespace App\Shared\Domain\Exceptions;

class NullException extends \Exception
{
    protected $code = 'C-E-200';
}