<?php

namespace App\Clients\Infrastructure\API\V1\Controller;

use App\Clients\Application\Command\CreateClient\CreateClientCommand;
use App\Clients\Domain\Client;
use App\Clients\Infrastructure\API\V1\Requests\CreateClientRequest;
use App\Clients\Infrastructure\API\V1\ViewFactory\ClientViewFactory;
use App\Shared\Application\Command\CommandSyncBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'api/v1/clients', name: 'api_v1_clients_client_create', methods: ['POST'])]
class CreateClientController
{

    public function __construct(
        private readonly CommandSyncBusInterface $commandSyncBus,
    ) {
    }

    public function __invoke(CreateClientRequest $request): JsonResponse
    {
        $client = $this->commandSyncBus->execute(
            new CreateClientCommand(
                firstName: $request->firstName,
                lastName: $request->lastName,
                dateOfBirth: $request->dateOfBirth,
                ssn: $request->ssn,
                email: $request->email,
                phoneNumber: $request->phoneNumber,
                state: $request->state,
                city: $request->city,
                street: $request->street,
                zipCode: $request->zipCode,
            ),
        );
        \assert($client instanceof Client);

        return new JsonResponse(['data' =>ClientViewFactory::jsonApi($client)]);

    }

}