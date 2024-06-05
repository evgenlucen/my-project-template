<?php

namespace App\Notifications\Domain\Event;

use App\Notifications\Domain\NotificationId;
use App\Notifications\Infrastructure\EventHandlers\NotificationCreatedEventHandler;
use App\Shared\Domain\Event\EventInterface;

/**
 * @see NotificationCreatedEventHandler
 */
class NotificationCreatedEvent implements EventInterface
{
    private readonly \DateTimeImmutable $occuredAt;

    public function __construct(
        public readonly NotificationId $notificationId,
    ) {
        $this->occuredAt = new \DateTimeImmutable();
    }

    public function getOccuredAt(): \DateTimeImmutable
    {
        return $this->occuredAt;
    }
}
