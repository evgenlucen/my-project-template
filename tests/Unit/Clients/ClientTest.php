<?php

namespace App\Tests\Unit\Clients;

use App\Clients\Domain\Client;
use App\Clients\Infrastructure\Util\FakeFactory\ClientFakeFactory;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function test_client_create_successful(): void
    {
        $client = ClientFakeFactory::createOne();

        self::assertInstanceOf(Client::class, $client);
    }

    public function test_cant_get_not_shifred_ssn(): void
    {
        // нельзя получить незахешированный SSN
        //todo implement
    }


}