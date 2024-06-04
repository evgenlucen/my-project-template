<?php

namespace App\Clients\Domain;

use App\Shared\Domain\Service\AssertService;

class FICO
{
    public function __construct(
        private readonly int $fico
    )
    {
        AssertService::greaterThanEq($this->fico, 300);
        AssertService::lessThanEq($this->fico, 850);
    }

    public function isLessThat(int $number): bool
    {
        return $this->fico < $number;
    }

    public function getValue(): int
    {
        return $this->fico;
    }
}