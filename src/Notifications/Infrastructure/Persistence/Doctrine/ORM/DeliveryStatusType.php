<?php

namespace App\Notifications\Infrastructure\Persistence\Doctrine\ORM;

use App\Notifications\Domain\DeliveryStatus;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class DeliveryStatusType extends StringType
{
    public const NAME = 'delivery_status';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): DeliveryStatus
    {
        return DeliveryStatus::from($value);
    }
}
