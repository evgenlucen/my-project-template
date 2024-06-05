<?php

namespace App\Credit\CreditRequests\Domain;

/**
 * Объект фиксирует данные, с которыми клиент обратился за кредитом.
 * Содержит только то, что нужно для расчета кредитным продуктам.
 */
class Borrower implements \JsonSerializable
{

    public function __construct(
        private readonly BorrowerId $id,
        private readonly int $age, // возраст на момент подачи заявки
        private readonly Address $address,
        private readonly int $fico,
    ) {
    }

    public static function create(
        BorrowerId $borrowerId,
        int $age,
        Address $address,
        int $fico,
    ): self {
        return new self (
            id: $borrowerId,
            age: $age,
            address: $address,
            fico: $fico,
        );
    }

    public static function fromPrimitives(array $borrowerInArray): self
    {
        return new self (
            id: new BorrowerId($borrowerInArray['id']),
            age: $borrowerInArray['age'],
            address: new Address(
                street: $borrowerInArray['address']['street'],
                city: $borrowerInArray['address']['city'],
                state: $borrowerInArray['address']['state'],
                zipCode: $borrowerInArray['address']['zipCode'],
            ),
            fico: (int) $borrowerInArray['fico'],
        );
    }


    public function getAge(): int
    {
        return $this->age;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getFico(): int
    {
        return $this->fico;
    }

    public function ficoIsLessThat(int $fico): bool
    {
        return $this->fico < $fico;
    }

    public function getId(): BorrowerId
    {
        return $this->id;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    private function toArray(): iterable
    {
        return [
            'address' => $this->address->toArray(),
            'id' => $this->id->toString(),
            'age' => $this->age,
            'fico' => $this->fico,
        ];
    }
}