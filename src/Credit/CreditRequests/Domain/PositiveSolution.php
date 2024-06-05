<?php

namespace App\Credit\CreditRequests\Domain;

use App\Credit\CreditProducts\Domain\PercentRate;
use App\Credit\CreditProducts\Domain\PeriodInMonths;

/**
 * Позитивное решение по кредитной заявке
 */
class PositiveSolution implements Solution
{
    public function __construct(
        private readonly BorrowerId $borrowerId,
        private readonly string $creditProductTitle,
        private readonly PercentRate $percentRate,
        private readonly CreditAmount $creditAmount,
        private readonly PeriodInMonths $periodInMonth,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'type' => $this->getType(),
            'borrowerId' => $this->borrowerId->toString(),
            'creditProductTitle' => $this->creditProductTitle,
            'percentRate' => $this->percentRate->getValue(),
            'creditAmount' => $this->creditAmount->toArray(),
            'periodInMonth' => $this->periodInMonth->getValue(),
        ];
    }

    public static function fromPrimitives(array $data): self
    {
        return new self (
            borrowerId: new BorrowerId($data['borrowerId']),
            creditProductTitle: $data['creditProductTitle'],
            percentRate: new PercentRate($data['pecentRate']),
            creditAmount: new CreditAmount(
                amount: $data['creditAmount']['amount'],
                currency: $data['creditAmount']['currency'],
            ),
            periodInMonth: new PeriodInMonths($data['periodInMonths']),
        );
    }

    public function getType(): SolutionType
    {
        return SolutionType::POSITIVE;
    }

    public function getBorrowerId(): BorrowerId
    {
        return $this->borrowerId;
    }

    public function getCreditProductTitle(): string
    {
        return $this->creditProductTitle;
    }

    public function getPercentRate(): PercentRate
    {
        return $this->percentRate;
    }

    public function getCreditAmount(): CreditAmount
    {
        return $this->creditAmount;
    }

    public function getPeriodInMonth(): PeriodInMonths
    {
        return $this->periodInMonth;
    }


}