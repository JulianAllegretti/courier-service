<?php

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\MaxLengthException;

class AdapterStringValueObject implements ValueObject
{
    use StringValueObject;

    /**
     * @throws MaxLengthException
     */
    public function __construct(private $value, protected string $name = '', protected int $maxLength = -1)
    {
        $this->stringInit($value, $this->name, $this->maxLength);
        $this->init();
    }

    /**
     * @throws MaxLengthException
     */
    public function init(): void
    {
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