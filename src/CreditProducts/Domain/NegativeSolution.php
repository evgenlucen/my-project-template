<?php

namespace App\CreditProducts\Domain;

use App\Clients\Domain\Client;
use App\Clients\Domain\ClientId;

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

    public function getClientId(): ClientId
    {
        return $this->client->getId();
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