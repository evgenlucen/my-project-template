<?php

namespace App\CreditRequests\Application\Query\GetSolution;

use App\Clients\Domain\ClientRepository;
use App\CreditProducts\Domain\CreditAmount;
use App\CreditProducts\Domain\PeriodInMonths;
use App\CreditProducts\Domain\Products\SomeCreditProduct;
use App\CreditProducts\Domain\Solution;
use App\CreditRequests\Domain\CreditRequest;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetSolutionQueryHandler implements QueryHandlerInterface
{

    public function __construct(
        private readonly ClientRepository $clientRepository,
    ) {
    }

    public function __invoke(GetSolutionQuery $query): Solution
    {
        $client = $this->clientRepository->getById($query->clientId);

        $creditRequest = CreditRequest::create(
            creditAmount: new CreditAmount($query->creditAmount),
            periodInMonths: new PeriodInMonths($query->periodInMonths),
            client: $client,
        );

        $someCreditProduct = SomeCreditProduct::create();

        return $someCreditProduct->calculateSolution($creditRequest);
    }
}