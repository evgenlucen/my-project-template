<?php

namespace App\Credit\CreditRequests\Infrastructure\Adapters;

use App\Clients\Domain\Client;
use App\Clients\Infrastructure\API\Context\ClientContextApi;
use App\Credit\CreditRequests\Domain\Borrower;

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
            age: $client->getDateOfBirth()->getAge(),
            address: $client->getAddress(),
            fico: $client->getFico(),
        );
    }
}