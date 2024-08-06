<?php

namespace App\Shared\Domain\Exceptions;

class DocumentNotExistException extends \Exception
{
    protected $code = 'C-E-800';
}