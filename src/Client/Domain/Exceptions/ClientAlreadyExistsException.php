<?php

namespace App\Client\Domain\Exceptions;

use App\Client\Domain\ClientId;
use App\Shared\Domain\Exceptions\EntityNotExists;

class ClientAlreadyExistsException extends EntityNotExists
{
    public function __construct(ClientId $clientId)
    {
        parent::__construct(sprintf('Client with id: %s already exists', $clientId->getId()));
    }
}