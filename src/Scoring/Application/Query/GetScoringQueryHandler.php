<?php

namespace App\Scoring\Application\Query;

use App\Scoring\Domain\ApiClient;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetScoringQueryHandler implements QueryHandlerInterface
{

    public function __construct(private readonly ApiClient $apiClient)
    {
    }

    public function __invoke(GetScoringQuery $query): int
    {
        return $this->apiClient->calculateFico($query->ssn);
    }
}