<?php

namespace App\Clients\Application\Query\FindClientById;

use App\Clients\Domain\Client;
use App\Clients\Domain\ClientId;
use App\Clients\Domain\ClientRepository;
use App\Clients\Domain\Exceptions\ClientNotExistsException;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetClientByIdQueryHandler implements QueryHandlerInterface
{

    public function __construct(
        private readonly ClientRepository $clientRepository,
    ) {
    }

    /**
     * @throws ClientNotExistsException
     */
    public function __invoke(GetClientByIdQuery $query): ?Client
    {
        return $this->clientRepository->getById(new ClientId($query->clientId));
    }
}