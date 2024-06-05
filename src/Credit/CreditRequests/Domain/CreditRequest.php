<?php

namespace App\Credit\CreditRequests\Domain;

use App\Credit\CreditProducts\Domain\PeriodInMonths;
use App\Credit\CreditRequests\Domain\Events\CreditRequestGotSolution;
use App\Shared\Domain\Entity\Aggregate;

class CreditRequest extends Aggregate
{

    private Solution $solution;

    private function __construct(
        private readonly CreditRequestId $id,
        private readonly Borrower $borrower,
        private readonly PeriodInMonths $periodInMonths,
        private readonly CreditAmount $creditAmount,
    ) {
    }

    public static function create(
        CreditAmount $creditAmount,
        PeriodInMonths $periodInMonths,
        Borrower $borrower,
    ): self {
        // event creditRequest created ?
        return new self(
            id: CreditRequestId::generate(),
            borrower: $borrower,
            periodInMonths: $periodInMonths,
            creditAmount: $creditAmount,
        );
    }


    public function addSolution(Solution $solution): void
    {
        $this->solution = $solution;
        $this->recordEvent(new CreditRequestGotSolution($this->id));
    }

    public function getBorrower(): Borrower
    {
        return $this->borrower;
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