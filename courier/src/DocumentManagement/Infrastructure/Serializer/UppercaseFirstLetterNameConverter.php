<?php

namespace App\DocumentManagement\Infrastructure\Serializer;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class UppercaseFirstLetterNameConverter implements NameConverterInterface
{
    public function normalize(string $propertyName): string
    {
        return ucfirst($propertyName);
    }

    public function denormalize(string $propertyName): string
    {
        return lcfirst($propertyName);
    }
}