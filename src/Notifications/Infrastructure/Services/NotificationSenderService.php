<?php

namespace App\Notifications\Infrastructure\Services;

use App\Notifications\Domain\DeliveryTool;
use App\Notifications\Domain\Notification;
use App\Notifications\Domain\NotificationSender;
use App\Notifications\Infrastructure\Adapter\TelegramBotAdapter;

class NotificationSenderService implements NotificationSender
{
    public function __construct(private readonly TelegramBotAdapter $telegramBotAdapter)
    {
    }

    public function sendNotification(Notification $notification): void
    {
        if (DeliveryTool::TELEGRAM == $notification->getDeliveryTool()) {
            $this->telegramBotAdapter->sendNotification($notification);
        }
    }
}
