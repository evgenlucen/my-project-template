<?php

namespace App\Notifications\Domain\Event;

use App\Shared\Domain\Event\EventInterface;

class NotificationSentSuccess implements EventInterface
{
    private readonly \DateTimeImmutable $occuredAt;
    public function __construct(
        public readonly string $notificationId
    ) {
        $this->occuredAt = new \DateTimeImmutable();
    }
    public function getOccuredAt(): \DateTimeImmutable
    {
        return $this->occuredAt;
    }
}
