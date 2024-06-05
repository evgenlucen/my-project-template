<?php

namespace App\Clients\Infrastructure\API\V1\Controller;

use App\Clients\Application\Command\CreateClient\CreateClientCommand;
use App\Clients\Application\Command\UpdateClient\UpdateClientCommand;
use App\Clients\Domain\Client;
use App\Clients\Infrastructure\API\V1\Requests\CreateClientRequest;
use App\Clients\Infrastructure\API\V1\Requests\UpdateClientRequest;
use App\Clients\Infrastructure\API\V1\ViewFactory\ClientViewFactory;
use App\Shared\Application\Command\CommandSyncBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'api/v1/clients/{id}', name: 'api_v1_clients_client_update', methods: ['PATCH'])]
class UpdateClientController
{

    public function __construct(
        private readonly CommandSyncBusInterface $commandSyncBus,
    ) {
    }

    public function __invoke(UpdateClientRequest $request, string $id): JsonResponse
    {
        $client = $this->commandSyncBus->execute(
            new UpdateClientCommand(
                id: $id,
                firstName: $request->firstName,
                lastName: $request->lastName,
                ssn: $request->ssn,
                email: $request->email,
                zipCode: $request->zipCode,
            ),
        );
        \assert($client instanceof Client);

        return new JsonResponse(['data' => ClientViewFactory::jsonApi($client)]);

    }

}