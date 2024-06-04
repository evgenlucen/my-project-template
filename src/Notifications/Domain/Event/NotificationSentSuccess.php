<?php

namespace App\Notifications\Domain\Event;

use App\Shared\Domain\Event\EventInterface;

class NotificationSentSuccess implements EventInterface
{
    public function __construct(
        public readonly string $notificationId
    ) {
    }
}
