<?php

namespace App\Client\Domain\Exceptions;

use App\Client\Domain\ClientId;
use App\Shared\Domain\Exceptions\EntityNotExists;

class ClientNotExistsException extends EntityNotExists
{
    public function __construct(ClientId $clientId)
    {
        parent::__construct(sprintf('Client with id: %s not found', $clientId->getId()));
    }
}