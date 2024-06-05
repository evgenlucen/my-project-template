<?php

namespace App\Clients\Infrastructure\API\Context;

use App\Clients\Application\Query\FindClientById\GetClientByIdQuery;
use App\Clients\Domain\Client;
use App\Shared\Application\Query\QueryBusInterface;

class ClientContextApi
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function getClientById(string $clientId): Client
    {
        return $this->queryBus->execute(new GetClientByIdQuery($clientId));
    }
}