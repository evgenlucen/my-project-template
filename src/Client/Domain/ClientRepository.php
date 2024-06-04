<?php

namespace App\Client\Domain;

use App\Client\Domain\Exceptions\ClientNotExistsException;

interface ClientRepository
{
    /**
     * @throws ClientNotExistsException
     */
    public function getById(ClientId $clientId): Client;

    public function save(Client $client): void;

    public function findBySsn(SSN $ssn): ?Client;
}