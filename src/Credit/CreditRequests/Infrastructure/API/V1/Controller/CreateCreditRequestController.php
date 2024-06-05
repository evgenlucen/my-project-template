<?php

namespace App\Credit\CreditRequests\Infrastructure\API\V1\Controller;

use App\Clients\Domain\ClientId;
use App\Credit\CreditRequests\Application\Command\CreateCreditRequest\CreateCreditRequestCommand;
use App\Credit\CreditRequests\Infrastructure\API\V1\Requests\CreateCreditRequestRequest;
use App\Shared\Application\Command\CommandSyncBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/v1/credit-requests', name: 'api_v1_credit_request_create', methods: ['POST'])]
class CreateCreditRequestController
{
    public function __construct(
        private readonly CommandSyncBusInterface $commandBus,
    ) {
    }

    public function __invoke(CreateCreditRequestRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new CreateCreditRequestCommand(
                clientId: new ClientId($request->clientId),
                periodInMonths: $request->periodInMonths,
                creditAmount: $request->creditAmount,
            ),
        );

        return new JsonResponse(
            [
                'success' => true,
                'message' => 'Создана заявка на получение кредита, мы проинформируем вас о результате на Email и в SMS',
            ],
        );
    }
}