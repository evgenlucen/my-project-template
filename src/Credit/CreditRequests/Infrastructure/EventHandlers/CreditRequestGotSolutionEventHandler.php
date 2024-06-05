<?php

namespace App\Credit\CreditRequests\Infrastructure\EventHandlers;

use App\Credit\CreditRequests\Domain\CreditRequestRepository;
use App\Credit\CreditRequests\Domain\Events\CreditRequestGotSolution;
use App\Credit\CreditRequests\Infrastructure\Adapters\NotificationsAdapter;
use App\Shared\Domain\Event\EventHandlerInterface;

class CreditRequestGotSolutionEventHandler implements EventHandlerInterface
{

    public function __construct(
        private readonly NotificationsAdapter $notificationsAdapter,
        private readonly CreditRequestRepository $creditRequestRepository,
    ) {
    }

    public function __invoke(
        CreditRequestGotSolution $event,
    ): void {
        $creditRequest = $this->creditRequestRepository->getById($event->id);
        $this->notificationsAdapter->createNotificationForCreditRequestSolution($creditRequest);
    }
}