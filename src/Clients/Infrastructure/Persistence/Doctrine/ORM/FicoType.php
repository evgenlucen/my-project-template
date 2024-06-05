<?php

namespace App\Clients\Infrastructure\Persistence\Doctrine\ORM;

use App\Clients\Domain\FICO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

class FicoType extends IntegerType
{
    public function getName(): string
    {
        return 'fico_type';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?FICO
    {
        return !empty($value) ? new FICO((int) $value) : null;
    }
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof FICO ? $value->getValue() : $value;
    }
}