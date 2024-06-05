<?php

namespace App\Clients\Domain;

use App\Shared\Infrastructure\API\FormatConstants\DateTimeFormat;

class DateOfBirth
{
    public function __construct(
        private readonly \DateTimeImmutable $dateOfBirth,
    ) {
    }

    public static function fromString(string $dateOfBirth)
    {
        return new self(\DateTimeImmutable::createFromFormat(DateTimeFormat::api(),$dateOfBirth));
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