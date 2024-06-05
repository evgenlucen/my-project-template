<?php

namespace App\Credit\CreditRequests\Application\Command\CreateCreditRequest;

use App\Clients\Domain\ClientId;
use App\Shared\Application\Command\CommandInterface;

/**
 * @see CreateCreditRequestCommandHandler
 */
class CreateCreditRequestCommand implements CommandInterface
{
    public function __construct(
        public readonly string $clientId,
        public readonly int $periodInMonths,
        public readonly float $creditAmount,
    ) {
    }
}