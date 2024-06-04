<?php

namespace App\CreditProducts\Domain;

use App\Clients\Domain\Client;
use App\CreditRequests\Domain\CreditRequest;

interface CreditProduct
{
    public function getTitle(): string;

    #public function getPeriodInMonths(): PeriodInMonths;

    public function getBasePercentRate(): PercentRate;

    #public function getCreditAmount(): CreditAmount;

    public function calculateSolution(CreditRequest $creditRequest): Solution;
}