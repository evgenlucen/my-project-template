<?php

namespace App\Clients\Infrastructure\Persistence\Doctrine\Repository;

use App\Clients\Domain\Client;
use App\Clients\Domain\ClientId;
use App\Clients\Domain\SSN;

class DoctrineClientRepository implements \App\Clients\Domain\ClientRepository
{

    /**
     * @inheritDoc
     */
    public function getById(ClientId $clientId): Client
    {
        // TODO: Implement getById() method.
    }

    public function save(Client $client): void
    {
        // TODO: Implement save() method.
    }

    public function findBySsn(SSN $ssn): ?Client
    {
        // TODO: Implement findBySsn() method.
    }
}