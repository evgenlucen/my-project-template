<?php

namespace App\Credit\CreditProducts\Domain;

use App\Shared\Domain\Service\AssertService;

class PercentRate
{
    public function __construct(
        private readonly float $percentRate
    )
    {
        AssertService::positiveInteger((int) $this->percentRate);
    }

    public function getValue(): float
    {
        return $this->percentRate;
    }

    public function increaseBy(float $percentRate): PercentRate
    {
        return new self($this->percentRate + $percentRate);
    }
}