<?php

namespace App\Credit\CreditRequests\Infrastructure\Adapters;

use App\Clients\Domain\Client;
use App\Clients\Infrastructure\API\Context\ClientContextApi;
use App\Credit\CreditRequests\Domain\Address;
use App\Credit\CreditRequests\Domain\Borrower;
use App\Credit\CreditRequests\Domain\BorrowerId;

class ClientAdapter
{
    public function __construct(
        private readonly ClientContextApi $clientContextApi,
    ) {
    }

    public function getBorrowerByClientId(string $id): Borrower
    {
        /** @var Client $client */
        $client = $this->clientContextApi->getClientById($id);

        return Borrower::create(
            borrowerId: new BorrowerId($client->getId()->toString()),
            age: $client->getDateOfBirth()->getAge(),
            address: new Address(
                street: $client->getAddress()->getStreet(),
                city: $client->getAddress()->getCity(),
                state: $client->getAddress()->getState(),
                zipCode: $client->getAddress()->getZipCode(),
            ),
            fico: $client->getFico()->getValue(),
        );
    }

    public function getBorrowerPhone(string $id): string
    {
        /** @var Client $client */
        $client = $this->clientContextApi->getClientById($id);

        return $client->getPhoneNumber()->getValue();
    }

    public function getBorrowerEmail(string $id): string
    {
        /** @var Client $client */
        $client = $this->clientContextApi->getClientById($id);

        return $client->getEmail()->getValue();
    }
}