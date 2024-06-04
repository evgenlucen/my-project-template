<?php

namespace App\Notifications\Application\Send;

use App\Notifications\Domain\NotificationRepository;
use App\Notifications\Domain\NotificationSender;
use App\Shared\Application\Command\CommandHandlerInterface;

class SendNotificationCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
        private readonly NotificationSender $notificationSender
    ) {
    }

    public function __invoke(SendNotificationCommand $command): void
    {
        $notification = $this->notificationRepository->getById($command->notificationId);
        $this->notificationSender->sendNotification($notification);
    }
}
