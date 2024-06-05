<?php

namespace App\Tests\Unit\CreditProducts;

use App\Clients\Domain\FICO;
use App\Clients\Infrastructure\Util\FakeFactory\ClientFakeFactory;
use App\Credit\CreditProducts\Domain\PeriodInMonths;
use App\Credit\CreditProducts\Domain\Products\SomeCreditProduct;
use App\Credit\CreditRequests\Domain\Borrower;
use App\Credit\CreditRequests\Domain\CreditAmount;
use App\Credit\CreditRequests\Domain\CreditRequest;
use App\Credit\CreditRequests\Domain\NegativeSolution;
use App\Credit\CreditRequests\Domain\PositiveSolution;
use PHPUnit\Framework\TestCase;

class SomeCreditProductTest extends TestCase
{
    public function test_reject_solution_if_fico_less_in_configuration()
    {
        $client = ClientFakeFactory::createOne();
        $client->updateFico(new FICO(SomeCreditProduct::FICO_MINIMAL - 1));

        $borrower = Borrower::create($client->getDateOfBirth()->getAge(),$client->getAddress(),$client->getFico());

        $creditRequest = CreditRequest::create(
            creditAmount: new CreditAmount(1_000_000),
            periodInMonths: new PeriodInMonths(120),
            borrower: $borrower,
        );

        $someProduct = SomeCreditProduct::create();
        $solution = $someProduct->calculateSolution($creditRequest);

        self::assertInstanceOf(NegativeSolution::class, $solution);
        self::assertEquals('Ваш кредитный рейтинг слишком мал', $solution->getRejectMessage());
    }

    public function test_positive_solution_if_fico_great_in_configuration()
    {
        $client = ClientFakeFactory::createOne();
        $client->updateFico(new FICO(SomeCreditProduct::FICO_MINIMAL + 1));
        $borrower = Borrower::create($client->getDateOfBirth()->getAge(),$client->getAddress(),$client->getFico());

        $creditRequest = CreditRequest::create(
            creditAmount: new CreditAmount(1_000_000),
            periodInMonths: new PeriodInMonths(120),
            borrower: $borrower,
        );

        $someProduct = SomeCreditProduct::create();
        $solution = $someProduct->calculateSolution($creditRequest);

        self::assertInstanceOf(PositiveSolution::class, $solution);
    }
}