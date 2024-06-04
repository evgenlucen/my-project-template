<?php

namespace App\Client\Domain;

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

    public function getValue(): int
    {
        return $this->fico;
    }
}