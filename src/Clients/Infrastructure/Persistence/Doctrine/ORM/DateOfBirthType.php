<?php

namespace App\Clients\Infrastructure\Persistence\Doctrine\ORM;

use App\Clients\Domain\DateOfBirth;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;

class DateOfBirthType extends DateTimeImmutableType
{
    public function getName(): string
    {
        return 'date_of_birth_type';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof DateOfBirth ? parent::convertToDatabaseValue($value->getValue(), $platform) : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateOfBirth
    {
        return !empty($value) ? new DateOfBirth(parent::convertToPHPValue($value, $platform)) : null;
    }
}