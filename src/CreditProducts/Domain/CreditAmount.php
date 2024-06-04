<?php

namespace App\CreditProducts\Domain;

use App\Shared\Domain\Service\AssertService;

class CreditAmount
{
    private readonly float $amount;

    public function __construct(
        float $amount,
        private readonly string $currency = 'USD'
    ) {
        AssertService::positiveInteger((int) $amount);
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getValue(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency
        ];
    }
}