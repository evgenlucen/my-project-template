<?php

namespace App\Clients\Infrastructure\Persistence\Doctrine\ORM;


use App\Clients\Domain\AmericanPhoneNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class PhoneNumberType extends StringType
{
    public function getName(): string
    {
        return 'phone_number_type';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?AmericanPhoneNumber
    {
        return !empty($value) ? new AmericanPhoneNumber((string) $value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof AmericanPhoneNumber ? $value->getValue() : $value;
    }
}