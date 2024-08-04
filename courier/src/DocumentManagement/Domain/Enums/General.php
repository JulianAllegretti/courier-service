<?php

namespace App\DocumentManagement\Domain\Enums;

use App\Shared\Domain\Exceptions\ValueException;

trait General
{
    /**
     * @throws ValueException
     */
    public static function fromName(string $name): self
    {
        $type = '';
        foreach (self::cases() as $status) {
            $type = $status->getType();
            if( strtolower($name) === strtolower($status->name) ){
                return $status;
            }
        }
        throw new ValueException("$name no es un valor valido para " . $type );
    }

    /**
     * @throws ValueException
     */
    public static function fromValue(string $value): self
    {
        $type = '';
        foreach (self::cases() as $status) {
            $type = $status->getType();
            if( strtolower($value) === strtolower($status->value) ){
                return $status;
            }
        }
        throw new ValueException("$value no es un valor valido para " .  $type);
    }
}