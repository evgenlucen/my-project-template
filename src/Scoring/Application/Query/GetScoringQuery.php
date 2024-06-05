<?php

namespace App\Scoring\Application\Query;

use App\Shared\Application\Query\QueryInterface;

class GetScoringQuery implements QueryInterface
{
    public function __construct(
        public readonly string $ssn,
    ) {
    }
}