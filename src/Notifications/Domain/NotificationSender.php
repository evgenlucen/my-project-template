<?php

namespace App\Notifications\Domain;

interface NotificationSender
{
    public function sendNotification(Notification $notification): void;
}
