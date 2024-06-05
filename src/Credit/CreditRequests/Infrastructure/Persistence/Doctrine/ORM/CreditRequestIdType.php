<?php

declare(strict_types=1);

namespace App\Credit\CreditRequests\Infrastructure\Persistence\Doctrine\ORM;

use App\Credit\CreditRequests\Domain\CreditRequestId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class CreditRequestIdType extends StringType
{
    public function getName(): string
    {
        return 'credit_request_id';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new CreditRequestId((string) $value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof CreditRequestId ? $value->toString() : $value;
    }
}
