<?php

namespace App\Clients\Infrastructure\Adapters;

use App\Clients\Domain\FICO;
use App\Clients\Domain\SSN;
use App\Scoring\Infrastructure\ScoringContextApi;

class ScoringAdapter
{
    public function __construct(
        private readonly ScoringContextApi $scoringContextApi,
    ) {
    }

    public function getFicoBySsn(SSN $ssn): FICO
    {
        return new FICO($this->scoringContextApi->getFicoBySsn($ssn->getOriginalSsn()));
    }
}