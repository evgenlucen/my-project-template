<?php

namespace App\Credit\CreditRequests\Application\Command\CreateCreditRequest;

use App\Credit\CreditProducts\Domain\PeriodInMonths;
use App\Credit\CreditProducts\Domain\Products\SomeCreditProduct;
use App\Credit\CreditRequests\Domain\CreditAmount;
use App\Credit\CreditRequests\Domain\CreditRequest;
use App\Credit\CreditRequests\Domain\CreditRequestRepository;
use App\Credit\CreditRequests\Domain\Events\CreditRequestGotSolution;
use App\Credit\CreditRequests\Infrastructure\Adapters\ClientAdapter;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Domain\Event\EventInterface;

class CreateCreditRequestCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ClientAdapter $clientAdapter,
        private readonly CreditRequestRepository $creditRequestRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateCreditRequestCommand $command): void
    {
        $borrower = $this->clientAdapter->getBorrowerByClientId($command->clientId);


        $creditRequest = CreditRequest::create(
            creditAmount: new CreditAmount($command->creditAmount),
            periodInMonths: new PeriodInMonths($command->periodInMonths),
            borrower: $borrower,
        );

        // для упрощения полагаем, что у нас всего один кредитный продукт.
        // путей для масштабирования продуктов множество, от хранения условий в коде, как реализовано сейчас
        // до написания собственного языка для формирования гибких условий Бизнес аналитиками в интерфейсе.
        $someCreditProduct = SomeCreditProduct::create();

        $creditRequest->addSolution($someCreditProduct->calculateSolution($creditRequest));

        $this->creditRequestRepository->save($creditRequest);

        // публикуем событие, что решение получено
        // далее его обработчик разошлет уведомления с решением заинтересованным лицам
        array_map(
            fn(EventInterface $event) => $this->eventBus->execute(
                new CreditRequestGotSolution($creditRequest->getId()),
            ),
            $creditRequest->releaseEvents(),
        );
    }
}