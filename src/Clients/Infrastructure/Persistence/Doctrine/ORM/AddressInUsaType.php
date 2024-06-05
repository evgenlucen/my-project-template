<?php

namespace App\Clients\Infrastructure\Persistence\Doctrine\ORM;

use App\Clients\Domain\AddressInUSA;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

class AddressInUsaType extends JsonType
{
    public function getName(): string
    {
        return 'address_type';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?AddressInUSA
    {
        $addressInArrayOrNull = parent::convertToPHPValue($value, $platform);

        if ($addressInArrayOrNull === null) {
            return null;
        }

        try {
            return new AddressInUSA(
                street: $addressInArrayOrNull['street'],
                city: $addressInArrayOrNull['city'],
                state: $addressInArrayOrNull['state'],
                zipCode: $addressInArrayOrNull['zipCode'],
            );
        } catch (\Throwable) {
            throw new \RuntimeException('НЕ удалось собрать адрес из значения базы данных' );
        }
    }
}