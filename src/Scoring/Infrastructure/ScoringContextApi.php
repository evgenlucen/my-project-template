<?php

namespace App\Scoring\Infrastructure;

use App\Scoring\Application\Query\GetScoringQuery;
use App\Shared\Application\Query\QueryBusInterface;

class ScoringContextApi
{

    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function getFicoBySsn(string $ssn): int
    {
        return $this->queryBus->execute(new GetScoringQuery($ssn));
    }
}