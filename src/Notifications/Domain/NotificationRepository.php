<?php

namespace App\Notifications\Domain;

interface NotificationRepository
{
    public function save(Notification $notification): void;

    public function delete(Notification $notification): void;

    /**
     * @return Notification[]|array
     */
    public function getAll(): array;

    /**
     * @return Notification[]|array
     */
    public function getByStatus(DeliveryStatus $status): array;

    public function getById(string $id): Notification;
}
