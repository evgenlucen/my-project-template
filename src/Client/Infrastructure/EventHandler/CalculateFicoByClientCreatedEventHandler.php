<?php

namespace App\Client\Infrastructure\EventHandler;

use App\Client\Domain\ClientRepository;
use App\Client\Domain\Events\ClientCreated;
use App\Client\Domain\FicoCalculator;

/**
 * Рассчитывает кредитный рейтинг клиента после
 * его создания.
 */
class CalculateFicoByClientCreatedEventHandler
{
    public function __construct(
        private readonly FicoCalculator $calculator,
        private readonly ClientRepository $clientRepository,
    )
    {
    }

    public function __invoke(ClientCreated $event): void
    {
        $client = $this->clientRepository->getById($event->clientId);
        $fico = $this->calculator->calculateFico($client);

        $client->updateFico($fico);
        $this->clientRepository->save($client);
    }
}