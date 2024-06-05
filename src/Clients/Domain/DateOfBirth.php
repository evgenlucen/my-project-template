<?php

namespace App\Clients\Domain;

class DateOfBirth
{
    public function __construct(
        private readonly \DateTimeImmutable $dateOfBirth,
    ) {
    }

    public static function fromString(string $dateOfBirth)
    {
        return new self(\DateTimeImmutable::createFromFormat(DATE_RFC3339,$dateOfBirth));
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