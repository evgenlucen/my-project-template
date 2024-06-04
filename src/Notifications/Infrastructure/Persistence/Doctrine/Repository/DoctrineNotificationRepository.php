<?php

namespace App\Notifications\Infrastructure\Persistence\Doctrine\Repository;

use App\Notifications\Domain\DeliveryStatus;
use App\Notifications\Domain\Notification;
use App\Notifications\Domain\NotificationRepository;
use App\Shared\Infrastructure\Database\Persistence\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityNotFoundException;

class DoctrineNotificationRepository extends DoctrineRepository implements NotificationRepository
{
    public function save(Notification $notification): void
    {
        $this->persist($notification);
    }

    public function delete(Notification $notification): void
    {
        $this->remove($notification);
    }

    public function getAll(): array
    {
        return $this->repository(Notification::class)->findAll();
    }

    /**
     * @return array|Notification[]
     */
    public function getByStatus(DeliveryStatus $status): array
    {
        return $this->repository(Notification::class)->findBy(['deliveryStatus' => $status->value]);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getById(string $id): Notification
    {
        return $this->repository(Notification::class)->find($id) ?? throw new EntityNotFoundException(sprintf('Notification with id %s not found', $id));
    }
}
