<?php

namespace App\Clients\Domain\Events;

use App\Clients\Domain\ClientId;
use App\Shared\Domain\Event\EventInterface;

class ClientCreated implements EventInterface
{
    private readonly \DateTimeImmutable $occuredAt;

    public function __construct(
        public readonly ClientId $clientId,
    ) {
        $this->occuredAt = new \DateTimeImmutable();
    }

    public function getOccuredAt(): \DateTimeImmutable
    {
        return $this->occuredAt;
    }
}