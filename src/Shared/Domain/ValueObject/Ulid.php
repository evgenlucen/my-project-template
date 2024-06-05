<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Service\AssertService;
use App\Shared\Domain\Service\UlidService;

class Ulid
{
    private string $id;

    public function __construct(string $id)
    {
        AssertService::true(UlidService::isValid($id));
        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function generate(): static
    {
        return new static(UlidService::generate());
    }
}
