<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Type;

use App\Shared\Domain\ValueObject\Ulid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class UlidType extends StringType
{
    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }
        $className = $this->typeClassName();

        return new $className($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Ulid ? $value->toString() : $value;
    }
}
