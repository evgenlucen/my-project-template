<?php

namespace App\Notifications\Infrastructure\Persistence\Doctrine\ORM;

use App\Notifications\Domain\DeliveryTool;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class DeliveryToolType extends StringType
{
    public const NAME = 'delivery_tool';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): DeliveryTool
    {
        return DeliveryTool::from($value);
    }
}
