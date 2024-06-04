<?php

namespace App\Client\Application\Command\CreateClient;

use App\Shared\Application\Command\CommandInterface;

class CreateClientCommand implements CommandInterface
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly int $age,
        public readonly string $ssn,
        public readonly string $email,
        public readonly string $phoneNumber,
        public readonly string $state,
        public readonly string $city,
        public readonly string $street,
        public readonly string $zipCode,
    ) {
    }
}