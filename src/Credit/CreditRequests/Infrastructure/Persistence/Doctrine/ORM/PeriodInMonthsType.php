<?php

namespace App\Credit\CreditRequests\Infrastructure\Persistence\Doctrine\ORM;

use App\Credit\CreditProducts\Domain\PeriodInMonths;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

class PeriodInMonthsType extends IntegerType
{
    public function getName(): string
    {
        return 'period_in_months_type';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PeriodInMonths
    {
        return !empty($value) ? new PeriodInMonths((int) $value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof PeriodInMonths ? $value->getValue() : $value;
    }
}