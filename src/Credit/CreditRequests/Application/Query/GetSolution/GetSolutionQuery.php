<?php

namespace App\Credit\CreditRequests\Application\Query\GetSolution;

use App\Shared\Application\Query\QueryInterface;

class GetSolutionQuery implements QueryInterface
{
    public function __construct(
        public readonly string $clientId,
        public readonly int $periodInMonths,
        public readonly float $creditAmount,
        //валюту не спрашиваем для упрощения.
    ) {
    }
}