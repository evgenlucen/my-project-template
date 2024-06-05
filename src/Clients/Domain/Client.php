<?php

namespace App\Clients\Domain;

use App\Clients\Domain\Events\ClientCreated;
use App\Shared\Domain\Entity\Aggregate;
use App\Shared\Domain\Service\AssertService;

class Client extends Aggregate
{

    public function __construct(
        private readonly ClientId $id,
        private string $firstName,
        private string $lastName,
        private DateOfBirth $dateOfBirth,
        private AddressInUSA $address,
        private SSN $ssn, //todo храним только хэш + последние 4 цифры
        private ?FICO $fico,
        private Email $email,
        private AmericanPhoneNumber $phoneNumber,
        // createdAt, updatedAt не добавлены для упрощения.
    )
    {
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
        // событие FicoUpdated не публикуется для упрощения
    }

    public function updateAddressZipCode(string $zipCode): void
    {
        $address = new AddressInUSA(
            street: $this->address->getCity(),
            city: $this->address->getCity(),
            state: $this->address->getState(),
            zipCode: $zipCode,
        );

        $this->address = $address;
    }

    public function updateSsn(SSN $ssn): void
    {
        $this->ssn = $ssn;
        // событие об обновлении, если SSN влияет на FICO.
        // чтобы обновить FICO.
    }

    public function updateEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function updateFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function updateLastName(string $lastName): void
    {
        $this->lastName = $lastName;
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