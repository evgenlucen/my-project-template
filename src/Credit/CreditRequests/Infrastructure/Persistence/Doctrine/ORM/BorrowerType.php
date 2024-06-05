<?php

namespace App\Credit\CreditRequests\Infrastructure\Persistence\Doctrine\ORM;

use App\Credit\CreditRequests\Domain\Borrower;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

// для упрощения используем JSON
class BorrowerType extends JsonType
{
    public function getName(): string
    {
        return 'borrower_type';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Borrower
    {
        if (null === $value) {
            return null;
        }

        $borrowerInArray = \json_decode($value, true, JSON_THROW_ON_ERROR);

        return Borrower::fromPrimitives($borrowerInArray);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Borrower ? \json_encode($value, JSON_THROW_ON_ERROR) : null;
    }
}