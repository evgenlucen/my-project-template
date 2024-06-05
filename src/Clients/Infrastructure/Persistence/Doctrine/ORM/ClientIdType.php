<?php

declare(strict_types=1);

namespace App\Clients\Infrastructure\Persistence\Doctrine\ORM;

use App\Clients\Domain\ClientId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ClientIdType extends StringType
{
    public function getName(): string
    {
        return 'client_id';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new ClientId((string) $value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof ClientId ? $value->toString() : $value;
    }
}
