<?php

namespace App\Clients\Domain;

class DateOfBirth
{
    public function __construct(
        private readonly \DateTimeImmutable $dateOfBirth,
    ) {
    }

    public function getValue(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function getAge(): int
    {
        return $this->dateOfBirth->diff((new \DateTimeImmutable()))->y;
    }
}