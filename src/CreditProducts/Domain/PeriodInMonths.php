<?php

namespace App\CreditProducts\Domain;

use App\Shared\Domain\Service\AssertService;

class PeriodInMonths
{
    public function __construct(
        private readonly int $periodInMonths,
    ) {
        AssertService::positiveInteger($this->periodInMonths);
    }

    public function getValue(): int
    {
        return $this->periodInMonths;
    }

}