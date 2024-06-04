<?php

namespace App\Notifications\Infrastructure\Adapter;

use App\Notifications\Domain\Notification;
use App\TelegramFacade\Infrastructure\Api;

class TelegramBotAdapter
{
    public function __construct(private readonly Api $api)
    {
    }

    public function sendNotification(Notification $notification): void
    {
        $this->api->sendMessage(
            chatId: $notification->getRecipient(),
            text: $notification->getContent(),
        );
    }
}
