<?php

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\NullException;

trait NullIntValueObject
{
    protected $nullValue;
    protected string $name;

    public function nullInit($value, $name): void
    {
        $this->name = $name;
        $this->nullValue = $value;
    }

    /**
     * @throws NullException
     */
    public function nullInvoke(): void
    {
        if (is_null($this->nullValue)) {
            throw new NullException("El campo $this->name no puede ser nulo");
        }
    }
}