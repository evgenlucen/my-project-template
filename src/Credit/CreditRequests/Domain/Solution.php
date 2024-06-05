<?php

namespace App\Credit\CreditRequests\Domain;

/**
 * Решение по кредитной заявке.
 */
interface Solution extends \JsonSerializable
{
    public function getBorrowerId(): BorrowerId;

    public function getCreditProductTitle(): string;

    public function getType(): SolutionType;
}