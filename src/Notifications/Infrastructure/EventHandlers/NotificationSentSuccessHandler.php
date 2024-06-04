<?php

namespace App\Notifications\Infrastructure\EventHandlers;

use App\Notifications\Domain\DeliveryStatus;
use App\Notifications\Domain\Event\NotificationSentSuccess;
use App\Notifications\Domain\NotificationRepository;
use App\Shared\Domain\Event\EventHandlerInterface;

class NotificationSentSuccessHandler implements EventHandlerInterface
{
    public function __construct(
        private readonly NotificationRepository $repository,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(NotificationSentSuccess $event): void
    {
        $notification = $this->repository->getById($event->notificationId);
        $notification->delivered();
        $this->repository->save($notification);
    }
}
