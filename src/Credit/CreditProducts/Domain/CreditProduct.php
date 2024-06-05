<?php

namespace App\Credit\CreditProducts\Domain;

use App\Credit\CreditRequests\Domain\CreditRequest;
use App\Credit\CreditRequests\Domain\Solution;

interface CreditProduct
{
    public function getTitle(): string;

    #public function getPeriodInMonths(): PeriodInMonths;

    public function getBasePercentRate(): PercentRate;

    #public function getCreditAmount(): CreditAmount;

    public function calculateSolution(CreditRequest $creditRequest): Solution;
}