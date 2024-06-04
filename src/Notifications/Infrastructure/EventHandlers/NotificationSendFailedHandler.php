<?php

namespace App\Notifications\Infrastructure\EventHandlers;

use App\Notifications\Domain\DeliveryStatus;
use App\Notifications\Domain\Event\NotificationSendFailed;
use App\Notifications\Domain\NotificationRepository;
use App\Shared\Domain\Event\EventHandlerInterface;

class NotificationSendFailedHandler implements EventHandlerInterface
{
    public function __construct(
        private readonly NotificationRepository $repository,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(NotificationSendFailed $event): void
    {
        $notification = $this->repository->getById($event->notificationId);
        $notification->deliveryError();
        $this->repository->save($notification);
    }
}
