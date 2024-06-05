<?php

namespace App\Clients\Domain;

use App\Clients\Domain\Exceptions\ClientNotExistsException;

interface ClientRepository
{
    /**
     * @throws ClientNotExistsException
     */
    public function getById(ClientId $clientId): Client;

    public function save(Client $client): void;

    public function findBySsn(SSN $ssn): ?Client;

    public function findByEmail(Email $email);

    #public function findByPhone(AmericanPhoneNumber $phoneNumber);
}