<?php

namespace App\Notifications\Infrastructure\Api\V1\Controller;

use App\Notifications\Application\Create\CreateNotificationCommand;
use App\Notifications\Domain\DeliveryTool;
use App\Notifications\Domain\Notification;
use App\Shared\Application\Command\CommandSyncBusInterface;
use App\Shared\Domain\Formats\ProjectConst;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/notifications', name: 'create-notification', methods: ['POST'])]
class CreateNotificationController
{
    public function __construct(
        private readonly CommandSyncBusInterface $commandBus,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = \json_decode($request->getContent(), true);

        $deliveryTime = \DateTimeImmutable::createFromFormat(ProjectConst::DATETIME_FORMAT_API, $data['deliveryTime']);
        $content = $data['content'] ?? throw new \RuntimeException('Content error');
        $recipient = $data['recipient'] ?? throw new \RuntimeException('Recipient error');

        /** @var Notification $notification */
        $notification = $this->commandBus->execute(
            new CreateNotificationCommand(
                content: $content,
                recipient: $recipient,
                deliveryTool: DeliveryTool::TELEGRAM,
                deliveryTime: $deliveryTime
            )
        );

        return new JsonResponse(['message' => sprintf('Создано уведомление %s', $notification->getId())]);
    }
}
