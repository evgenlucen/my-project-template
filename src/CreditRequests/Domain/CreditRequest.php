<?php

namespace App\CreditRequests\Domain;

use App\Clients\Domain\Client;
use App\CreditProducts\Domain\CreditAmount;
use App\CreditProducts\Domain\PeriodInMonths;
use App\CreditProducts\Domain\Solution;
use App\CreditRequests\Domain\Events\CreditRequestGotSolution;
use App\Shared\Domain\Entity\Aggregate;
use App\Shared\Domain\ValueObject\Ulid;

class CreditRequest extends Aggregate
{

    private Solution $solution;

    private function __construct(
        private readonly CreditRequestId $id,
        private readonly Client $client,
        private readonly PeriodInMonths $periodInMonths,
        private readonly CreditAmount $creditAmount,
    ) {
    }

    public static function create(
        CreditAmount $creditAmount,
        PeriodInMonths $periodInMonths,
        Client $client,
    ): self {
        // event creditRequest created ?
        return new self(
            id: CreditRequestId::generate(),
            client: $client,
            periodInMonths: $periodInMonths,
            creditAmount: $creditAmount,
        );
    }


    public function addSolution(Solution $solution): void
    {
        $this->solution = $solution;
        $this->recordEvent(new CreditRequestGotSolution($this->id));
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getPeriodInMonths(): PeriodInMonths
    {
        return $this->periodInMonths;
    }

    public function getCreditAmount(): CreditAmount
    {
        return $this->creditAmount;
    }

    public function getId(): CreditRequestId
    {
        return $this->id;
    }

    public function getSolution(): Solution
    {
        return $this->solution;
    }
}