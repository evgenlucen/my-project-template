<?php

namespace App\Client\Domain;

use App\Shared\Domain\Service\AssertService;

class Email
{
    public function __construct(
        private readonly string $email
    )
    {
        AssertService::email($this->email);
    }

    public function getValue(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

}