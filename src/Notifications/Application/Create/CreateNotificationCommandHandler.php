<?php

namespace App\Notifications\Application\Create;

use App\Notifications\Domain\DeliveryStatus;
use App\Notifications\Domain\Notification;
use App\Notifications\Domain\NotificationRepository;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;

class CreateNotificationCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly NotificationRepository $repository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(CreateNotificationCommand $command): Notification
    {
        $notification = Notification::create(
            content: $command->content,
            recipient: $command->recipient,
            deliveryTool: $command->deliveryTool,
            deliveryStatus: DeliveryStatus::PLANNED,
            deliveryTime: $command->deliveryTime,
        );

        $this->repository->save($notification);

        // $this->eventBus->execute(new NotificationCreatedEvent($notification));

        return $notification;
    }
}
