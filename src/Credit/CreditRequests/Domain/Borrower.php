<?php

namespace App\Credit\CreditRequests\Domain;

use App\Clients\Domain\AddressInUSA;
use App\Clients\Domain\FICO;

/**
 * Объект фиксирует данные, с которыми клиент обратился за кредитом.
 * Содержит только то, что нужно для расчета кредитным продуктам.
 */
class Borrower implements \JsonSerializable
{

    public function __construct(
        private readonly BorrowerId $id,
        private readonly int $age, // возраст на момент подачи заявки
        private readonly AddressInUSA $address,
        private readonly FICO $fico,
    ) {
    }

    public static function create(
        int $age,
        AddressInUSA $address,
        FICO $fico,
    ): self {
        return new self (
            id: BorrowerId::generate(),
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
            address: new AddressInUSA(
                street: $borrowerInArray['address']['street'],
                city: $borrowerInArray['address']['city'],
                state: $borrowerInArray['address']['state'],
                zipCode: $borrowerInArray['address']['zipCode'],
            ),
            fico: new FICO($borrowerInArray['fico']),
        );
    }


    public function getAge(): int
    {
        return $this->age;
    }

    public function getAddress(): AddressInUSA
    {
        return $this->address;
    }

    public function getFico(): ?FICO
    {
        return $this->fico;
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
            'fico' => $this->fico->getValue(),
        ];
    }
}