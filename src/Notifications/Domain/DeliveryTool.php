<?php

namespace App\Notifications\Domain;

enum DeliveryTool: string
{
    case TELEGRAM = 'telegram';
    case EMAIL = 'email';

    case SMS = 'sms';
}
