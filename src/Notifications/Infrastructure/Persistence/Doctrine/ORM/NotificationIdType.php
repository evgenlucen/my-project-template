<?php

declare(strict_types=1);

namespace App\Notifications\Infrastructure\Persistence\Doctrine\ORM;

use App\Notifications\Domain\NotificationId;
use App\Shared\Infrastructure\Database\Type\UlidType;

class NotificationIdType extends UlidType
{
    protected function typeClassName(): string
    {
        return NotificationId::class;
    }

    public static function customTypeName(): string
    {
        return 'notification_id';
    }

}
