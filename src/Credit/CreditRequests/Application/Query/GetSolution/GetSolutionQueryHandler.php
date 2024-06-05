<?php

namespace App\Credit\CreditRequests\Application\Query\GetSolution;

use App\Credit\CreditProducts\Domain\PeriodInMonths;
use App\Credit\CreditProducts\Domain\Products\SomeCreditProduct;
use App\Credit\CreditRequests\Domain\CreditAmount;
use App\Credit\CreditRequests\Domain\CreditRequest;
use App\Credit\CreditRequests\Domain\Solution;
use App\Credit\CreditRequests\Infrastructure\Adapters\ClientAdapter;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetSolutionQueryHandler implements QueryHandlerInterface
{

    public function __construct(
        private readonly ClientAdapter $clientAdapter,
    ) {
    }

    public function __invoke(GetSolutionQuery $query): Solution
    {
        $borrower = $this->clientAdapter->getBorrowerByClientId($query->clientId);

        $creditRequest = CreditRequest::create(
            creditAmount: new CreditAmount($query->creditAmount),
            periodInMonths: new PeriodInMonths($query->periodInMonths),
            borrower: $borrower,
        );

        // для упрощения полагаем, что у нас всего один кредитный продукт.
        $someCreditProduct = SomeCreditProduct::create();

        return $someCreditProduct->calculateSolution($creditRequest);
    }
}