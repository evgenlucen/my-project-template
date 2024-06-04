<?php

namespace App\CreditProducts\Domain;

use App\Clients\Domain\Client;

/**
 * Решение по кредитной заявке.
 */
interface Solution
{
    public function getClient(): Client;

    public function getCreditProductTitle(): string;
}