<?php

namespace App\Notifications\Domain;

enum DeliveryStatus: string
{
    case PLANNED = 'planned';
    case DELIVERED = 'delivered';

    case DELIVERY_ERROR = 'delivery_error';
    case CANCELED = 'canceled';

    case SENT = 'send';
}
