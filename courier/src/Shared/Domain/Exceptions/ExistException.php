<?php

namespace App\Shared\Domain\Exceptions;

class ExistException extends \Exception
{
    protected $code = 'C-E-400';
}