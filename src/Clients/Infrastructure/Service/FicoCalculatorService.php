<?php

namespace App\Clients\Infrastructure\Service;

use App\Clients\Domain\Client;
use App\Clients\Domain\FICO;
use App\Clients\Domain\FicoCalculator;
use App\Clients\Infrastructure\Adapters\ScoringAdapter;

class FicoCalculatorService implements FicoCalculator
{

    public function __construct(
        private readonly ScoringAdapter $scorringAdapter,
    )
    {
    }

    public function calculateFico(Client $client): FICO
    {
        return $this->scorringAdapter->getFicoBySsn($client->getSsn());
    }
}