<?php

namespace App\Clients\Application\Query\FindClientById;

use App\Shared\Application\Query\QueryInterface;

/**
 * @see GetClientByIdQueryHandler
 */
class GetClientByIdQuery implements QueryInterface
{
    public function __construct(
        public readonly string $clientId,
    ) {
    }
}