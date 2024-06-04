<?php

namespace App\Clients\Domain;

use App\Clients\Domain\Events\ClientCreated;
use App\Shared\Domain\Entity\Aggregate;
use App\Shared\Domain\Service\AssertService;

class Client extends Aggregate
{

    public function __construct(
        private readonly ClientId $id,
        private readonly string $firstName,
        private readonly string $lastName,
        private DateOfBirth $dateOfBirth,
        private AddressInUSA $address,
        private readonly SSN $ssn, //todo храним только хэш + последние 4 цифры
        private ?FICO $fico,
        private Email $email,
        private AmericanPhoneNumber $phoneNumber,
    ) {
        AssertService::lengthBetween(
            $this->firstName,
            2,
            100,
            sprintf('Ошибка в имени: %s', $this->firstName),
        );
        AssertService::lengthBetween(
            $this->lastName,
            2,
            100,
            sprintf('Ошибка в фамилии: %s', $this->lastName),
        );
    }

    public static function create(
        string $firstName,
        string $lastName,
        DateOfBirth $age,
        AddressInUSA $address,
        SSN $ssn,
        ?FICO $fico,
        Email $email,
        AmericanPhoneNumber $phoneNumber,
    ): self {
        $client = new self (
            id: ClientId::generate(),
            firstName: $firstName,
            lastName: $lastName,
            dateOfBirth: $age,
            address: $address,
            ssn: $ssn,
            fico: $fico,
            email: $email,
            phoneNumber: $phoneNumber,
        );

        $client->recordEvent(new ClientCreated($client->getId()));

        return $client;
    }

    public function updateFico(FICO $fico): void
    {
        $this->fico = $fico;
        // событие FicoUpdated нигде не нужно по условиям задачи, не делаю
    }

    public function getId(): ClientId
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDateOfBirth(): DateOfBirth
    {
        return $this->dateOfBirth;
    }

    public function getAddress(): AddressInUSA
    {
        return $this->address;
    }

    public function getSsn(): SSN
    {
        return $this->ssn;
    }

    public function getFico(): ?FICO
    {
        return $this->fico;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPhoneNumber(): AmericanPhoneNumber
    {
        return $this->phoneNumber;
    }


}