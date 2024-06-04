<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Type;

use App\Shared\Domain\ValueObject\Ulid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UlidType extends GuidType
{
    protected function typeClassName(): string
    {
        return Ulid::class;
    }

    public static function customTypeName(): string
    {
        return 'ulid_type';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }
        $className = $this->typeClassName();

        return new $className($value);
    }
}
