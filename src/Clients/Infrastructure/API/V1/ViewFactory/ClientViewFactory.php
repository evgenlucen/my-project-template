<?php

namespace App\Clients\Infrastructure\API\V1\ViewFactory;

use App\Clients\Domain\Client;
use App\Shared\Infrastructure\API\FormatConstants\DateTimeFormat;

class ClientViewFactory
{

    public static function jsonApi(Client $client): array
    {
        return [
            'type' => 'clients',
            'id' => $client->getId()->toString(),
            'attributes' => [
                'firstName' => $client->getFirstName(),
                'lastName' => $client->getLastName(),
                'dateOfBirth' => $client->getDateOfBirth()->getValue()->format(DateTimeFormat::api()),
                'address' => $client->getAddress()->toArray(),
                'ssn' => $client->getSsn()->toPublicView(),
                'fico' => $client->getFico()?->getValue(),
                'email' => $client->getEmail()->getValue(),
                'phoneNumber' => $client->getPhoneNumber()->getValue(),
            ],
        ];
    }
}