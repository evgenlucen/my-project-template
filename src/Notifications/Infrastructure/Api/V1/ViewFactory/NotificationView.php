<?php

namespace App\Notifications\Infrastructure\Api\V1\ViewFactory;

use App\Notifications\Domain\Notification;
use App\Shared\Domain\Formats\ProjectConst;

class NotificationView
{
    /**
     * @return array<mixed>
     */
    public static function createView(Notification $notification): array
    {
        return [
            'id' => $notification->getId(),
            'content' => $notification->getContent(),
            'deliveryStatus' => $notification->getDeliveryStatus()->value,
            'deliveryTool' => $notification->getDeliveryTool()->value,
            'recipient' => $notification->getRecipient(),
            'deliveryTime' => $notification->getDeliveryTime()->format(ProjectConst::DATETIME_FORMAT_API),
            'createdAt' => $notification->getCreatedAt()->format(ProjectConst::DATETIME_FORMAT_API),
            'updatedAt' => $notification->getUpdatedAt()->format(ProjectConst::DATETIME_FORMAT_API),
        ];
    }

    /**
     * @param Notification[]|array $notifications
     */
    public static function createList(array $notifications): array
    {
        return array_map(static fn (Notification $notification) => self::createView($notification), $notifications);
    }
}
