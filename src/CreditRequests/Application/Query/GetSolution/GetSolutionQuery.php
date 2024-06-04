<?php

namespace App\CreditRequests\Application\Query\GetSolution;

use App\Clients\Domain\ClientId;
use App\Shared\Application\Query\QueryInterface;

class GetSolutionQuery implements QueryInterface
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly int $periodInMonths,
        public readonly float $creditAmount,
        //валюту не спрашиваем для упрощения.
    ) {
    }
}