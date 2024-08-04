<?php

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\MaxLengthException;

trait StringValueObject
{
    protected int $maxLength;
    protected ?string $stringValue;
    protected string $name;

    /**
     * @param int $maxLength
     * @param ?string $value
     * @param string $name
     */
    public function stringInit(?string $value, string $name, int $maxLength = -1): void
    {
        $this->maxLength = $maxLength;
        $this->stringValue = $value;
        $this->name = $name;
    }


    /**
     * @throws MaxLengthException
     */
    public function stringInvoke(): void
    {
        if (is_null($this->value)) {
            return;
        }

        if ($this->maxLength > 0 && strlen($this->stringValue) > $this->maxLength) {
            throw new MaxLengthException("El tamano maximo para $this->name es $this->maxLength");
        }
    }
}