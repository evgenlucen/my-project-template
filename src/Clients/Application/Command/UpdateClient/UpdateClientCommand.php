<?php

namespace App\Clients\Application\Command\UpdateClient;

use App\Shared\Application\Command\CommandInterface;

/**
 * Для упрощения принимаем за правду, что можно изменить только часть полей
 * а контракт предполагает, что присылаются только те поля, которые нужно обновить
 */
class UpdateClientCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $ssn = null,
        public readonly ?string $email = null,
        public readonly ?string $zipCode = null,
    ) {
    }
}