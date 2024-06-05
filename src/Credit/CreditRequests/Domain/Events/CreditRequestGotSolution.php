<?php

namespace App\Credit\CreditRequests\Domain\Events;

use App\Credit\CreditRequests\Domain\CreditRequestId;
use App\Shared\Domain\Event\EventInterface;

class CreditRequestGotSolution implements EventInterface
{
    private \DateTimeImmutable $occuredAt;

    public function __construct(public readonly CreditRequestId $id)
    {
        $this->occuredAt = new \DateTimeImmutable();
    }

    public function getOccuredAt(): \DateTimeImmutable
    {
        return $this->occuredAt;
    }
}