<?php

namespace App\Clients\Infrastructure\Persistence\Doctrine\ORM;

use App\Clients\Domain\SSN;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class SsnType extends StringType
{

    public function getName(): string
    {
        return 'ssn_type';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?SSN
    {
        return !empty($value) ? new SSN((string) $value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof SSN ? $value->getOriginalSsn() : $value;
    }
}