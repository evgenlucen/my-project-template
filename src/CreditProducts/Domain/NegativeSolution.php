<?php

namespace App\CreditProducts\Domain;

use App\Clients\Domain\Client;

/**
 * Негативное решение по кредитной заявке.
 */
class NegativeSolution implements Solution
{
    public function __construct(
        private readonly Client $client,
        private readonly string $creditProductTitle,
        private readonly string $rejectMessage, //причина отказа, видимая клиенту
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

    public function getRejectMessage(): string
    {
        return $this->rejectMessage;
    }
}