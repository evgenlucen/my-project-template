<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Event\EventInterface;
use App\Shared\Domain\ValueObject\Ulid;

abstract class Aggregate
{
    /**
     * @var EventInterface[]
     */
    private array $events = [];

    abstract public function getId(): Ulid;

    /**
     * @return EventInterface[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    protected function recordEvent(EventInterface $event): void
    {
        $this->events[] = $event;
    }
}
