<?php

namespace App\Credit\CreditRequests\Infrastructure\API\V1\Controller;

use App\Credit\CreditRequests\Application\Query\GetSolution\GetSolutionQuery;
use App\Credit\CreditRequests\Infrastructure\API\V1\Requests\GetSolutionRequest;
use App\Credit\CreditRequests\Infrastructure\API\V1\VIewFactory\SolutionViewFactory;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/v1/credit-requests:solution', name: 'api_v1_credit_request_get_solution', methods: ['POST'])]
class GetSolutionController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(GetSolutionRequest $request): JsonResponse
    {
        $solution = $this->queryBus->execute(
            new GetSolutionQuery(
                clientId: $request->clientId,
                periodInMonths: $request->periodInMonths,
                creditAmount: $request->creditAmount,
            ),
        );

        return new JsonResponse(SolutionViewFactory::jsonApi($solution));
    }
}