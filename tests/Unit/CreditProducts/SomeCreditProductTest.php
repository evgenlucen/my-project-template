<?php

namespace App\Tests\Unit\CreditProducts;

use App\Clients\Domain\FICO;
use App\Clients\Infrastructure\Util\FakeFactory\ClientFakeFactory;
use App\CreditProducts\Domain\CreditAmount;
use App\CreditProducts\Domain\NegativeSolution;
use App\CreditProducts\Domain\PeriodInMonths;
use App\CreditProducts\Domain\PositiveSolution;
use App\CreditProducts\Domain\Products\SomeCreditProduct;
use App\CreditRequests\Domain\CreditRequest;
use PHPUnit\Framework\TestCase;

class SomeCreditProductTest extends TestCase
{
    public function test_reject_solution_if_fico_less_in_configuration()
    {
        $client = ClientFakeFactory::createOne();
        $client->updateFico(new FICO(SomeCreditProduct::FICO_MINIMAL - 1));

        $creditRequest = CreditRequest::create(
            creditAmount: new CreditAmount(1_000_000),
            periodInMonths: new PeriodInMonths(120),
            client: $client,
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

        $creditRequest = CreditRequest::create(
            creditAmount: new CreditAmount(1_000_000),
            periodInMonths: new PeriodInMonths(120),
            client: $client,
        );

        $someProduct = SomeCreditProduct::create();
        $solution = $someProduct->calculateSolution($creditRequest);

        self::assertInstanceOf(PositiveSolution::class, $solution);
    }
}