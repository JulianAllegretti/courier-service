<?php

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\MaxLengthException;
use App\Shared\Domain\Exceptions\NullException;

class AdapterNullStringValueObject implements ValueObject
{

    use NullValueObject, StringValueObject;

    /**
     * @throws MaxLengthException
     * @throws NullException
     */
    public function __construct(private $value, protected string $name = '', protected int $maxLength = -1)
    {
        $this->nullInit($value, $this->name);
        $this->stringInit($value, $this->name, $this->maxLength);
        $this->init();
    }

    /**
     * @throws MaxLengthException
     * @throws NullException
     */
    public function init(): void
    {
        $this->nullInvoke();
        $this->stringInvoke();
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}