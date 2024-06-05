<?php

namespace App\Credit\CreditRequests\Domain;

/**
 * Негативное решение по кредитной заявке.
 */
class NegativeSolution implements Solution
{
    public function __construct(
        private readonly BorrowerId $borrowerId,
        private readonly string $creditProductTitle,
        private readonly string $rejectMessage, //причина отказа, видимая клиенту
    )
    {
    }


    public function getBorrowerId(): BorrowerId
    {
        return $this->borrowerId;
    }

    public function getCreditProductTitle(): string
    {
        return $this->creditProductTitle;
    }

    public function getRejectMessage(): string
    {
        return $this->rejectMessage;
    }

    public function getType(): SolutionType
    {
        return SolutionType::NEGATIVE;
    }

    public function jsonSerialize(): iterable
    {
        return [
            'type' => $this->getType()->value,
            'borrowerId' => $this->borrowerId->toString(),
            'creditProductTitle' => $this->creditProductTitle,
            'rejectMessage' => $this->rejectMessage,
        ];
    }

    public static function fromPrimitives(array $data): self
    {
        return new self (
            borrowerId: new BorrowerId($data['borrowerId']),
            creditProductTitle: $data['creditProductTitle'],
            rejectMessage: $data['rejectMessage'],
        );
    }
}