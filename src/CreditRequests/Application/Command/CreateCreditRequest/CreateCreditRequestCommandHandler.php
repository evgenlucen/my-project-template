<?php

namespace App\CreditRequests\Application\Command\CreateCreditRequest;

use App\Clients\Domain\ClientRepository;
use App\CreditProducts\Domain\CreditAmount;
use App\CreditProducts\Domain\PeriodInMonths;
use App\CreditProducts\Domain\Products\SomeCreditProduct;
use App\CreditRequests\Domain\CreditRequest;
use App\CreditRequests\Domain\CreditRequestRepository;
use App\CreditRequests\Domain\Events\CreditRequestGotSolution;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Domain\Event\EventInterface;

class CreateCreditRequestCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ClientRepository $clientRepository,
        private readonly CreditRequestRepository $creditRequestRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateCreditRequestCommand $command): void
    {
        $client = $this->clientRepository->getById($command->clientId);

        $creditRequest = CreditRequest::create(
            creditAmount: new CreditAmount($command->creditAmount),
            periodInMonths: new PeriodInMonths($command->periodInMonths),
            client: $client,
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