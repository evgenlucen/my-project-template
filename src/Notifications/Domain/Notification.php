<?php

namespace App\Notifications\Domain;

use App\Shared\Domain\Entity\Aggregate;
use App\Shared\Domain\Service\DateTimeService;
use App\Shared\Domain\Service\UlidService;

class Notification extends Aggregate
{
    private function __construct(
        private readonly NotificationId $id,
        private string $content,
        private string $recipient, // адресат
        private readonly DeliveryTool $deliveryTool, // средство доставки
        private DeliveryStatus $deliveryStatus,
        private \DateTimeImmutable $deliveryTime,// время для доставки
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
    ) {
        if (DateTimeService::createNow() > $this->deliveryTime && DeliveryStatus::PLANNED == $this->deliveryStatus) {
            throw new \DomainException('Нельзя запланировать уведомление в прошедшем времени');
        }
    }

    public static function create(
        string $content,
        string $recipient, // адресат
        DeliveryTool $deliveryTool, // средство доставки
        DeliveryStatus $deliveryStatus,
        \DateTimeImmutable $deliveryTime,// время для доставки
    ): self {
        $createdAt = DateTimeService::createNow();
        $updatedAt = DateTimeService::createNow();

        return new self(
            id: NotificationId::generate(),
            content: $content,
            recipient: $recipient,
            deliveryTool: $deliveryTool,
            deliveryStatus: $deliveryStatus,
            deliveryTime: $deliveryTime,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }

    public function updateRecipient(string $recipient): void
    {
        if (DeliveryStatus::PLANNED !== $this->deliveryStatus) {
            throw new \DomainException('Менять адресата можно только запланированным сообщениям.');
        }

        $this->recipient = $recipient;
        $this->updatedAt = DateTimeService::createNow();
    }

    public function updateContent(string $content): void
    {
        if (DeliveryStatus::PLANNED !== $this->deliveryStatus) {
            throw new \DomainException('Менять контент можно только запланированным сообщениям.');
        }

        $this->content = $content;
        $this->updatedAt = DateTimeService::createNow();
    }

    /**
     * Перезапланировать отправку сообщения.
     *
     * @throws \Exception
     */
    public function rescheduleNotification(\DateTimeImmutable $deliveryTime): void
    {
        if ($deliveryTime < DateTimeService::createNow()) {
            throw new \DomainException('Время отправки уведомления должно быть больше, чем текущее');
        }

        $this->deliveryTime = $deliveryTime;
        $this->deliveryStatus = DeliveryStatus::PLANNED;
        $this->updatedAt = DateTimeService::createNow();
    }

    public function deliveryError(): void
    {
        $this->deliveryStatus = DeliveryStatus::DELIVERY_ERROR;
        $this->updatedAt = DateTimeService::createNow();
    }

    public function delivered(): void
    {
        $this->deliveryStatus = DeliveryStatus::DELIVERED;
        $this->updatedAt = DateTimeService::createNow();
    }

    public function cancel(): void
    {
        $this->deliveryStatus = DeliveryStatus::CANCELED;
        $this->updatedAt = DateTimeService::createNow();
    }

    public function getId(): NotificationId
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getDeliveryTool(): DeliveryTool
    {
        return $this->deliveryTool;
    }

    public function getDeliveryStatus(): DeliveryStatus
    {
        return $this->deliveryStatus;
    }

    public function getDeliveryTime(): \DateTimeImmutable
    {
        return $this->deliveryTime;
    }


}
