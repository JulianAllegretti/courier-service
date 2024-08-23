<?php

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\MaxLengthException;
use App\Shared\Domain\Exceptions\NullException;

class AdapterNullIntValueObject implements ValueObject
{
    use NullIntValueObject;

    /**
     * @throws NullException
     */
    public function __construct(private $value, protected string $name)
    {
        $this->nullInit($value, $this->name);
        $this->init();
    }

    /**
     * @throws NullException
     */
    public function init(): void
    {
        $this->nullInvoke();
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}