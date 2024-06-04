<?php

namespace App\CreditProducts\Domain;

use App\Clients\Domain\Client;

/**
 * Позитивное решение по кредитной заявке
 */
class PositiveSolution implements Solution
{
    public function __construct(
        private readonly Client $client,
        private readonly string $creditProductTitle,
        private readonly PercentRate $percentRate,
        private readonly CreditAmount $creditAmount,
        private readonly PeriodInMonths $periodInMonth,
    ) {
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getCreditProductTitle(): string
    {
        return $this->creditProductTitle;
    }

    public function getPercentRate(): PercentRate
    {
        return $this->percentRate;
    }

    public function getCreditAmount(): CreditAmount
    {
        return $this->creditAmount;
    }

    public function getPeriodInMonth(): PeriodInMonths
    {
        return $this->periodInMonth;
    }
}