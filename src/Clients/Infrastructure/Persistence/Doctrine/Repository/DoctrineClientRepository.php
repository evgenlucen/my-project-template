<?php

namespace App\Clients\Infrastructure\Persistence\Doctrine\Repository;

use App\Clients\Domain\Client;
use App\Clients\Domain\ClientId;
use App\Clients\Domain\ClientRepository;
use App\Clients\Domain\Exceptions\ClientNotExistsException;
use App\Clients\Domain\SSN;
use App\Shared\Infrastructure\Database\Persistence\Doctrine\DoctrineRepository;

class DoctrineClientRepository extends DoctrineRepository implements ClientRepository
{

    public function getById(ClientId $clientId): Client
    {
        $client = $this->repository(Client::class)->find($clientId);
        if (!$client instanceof Client) {
            throw new ClientNotExistsException($clientId);
        }

        return $client;
    }

    public function save(Client $client): void
    {
        try {
            $this->persist($client);
        } catch (\Throwable $throwable) {
            dd($throwable);
        }
    }

    public function findBySsn(SSN $ssn): ?Client
    {
        return $this->repository(Client::class)->findOneBy(['ssn' => $ssn->getSSN()]);
    }
}