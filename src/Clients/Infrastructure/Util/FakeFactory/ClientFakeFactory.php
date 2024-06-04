<?php

namespace App\Clients\Infrastructure\Util\FakeFactory;

use App\Clients\Domain\AddressInUSA;
use App\Clients\Domain\AmericanPhoneNumber;
use App\Clients\Domain\Client;
use App\Clients\Domain\DateOfBirth;
use App\Clients\Domain\Email;
use App\Clients\Domain\SSN;
use App\Tests\Tools\FakerTools;

class ClientFakeFactory
{
    use FakerTools;

    //todo заменить на zenstruck/foundry
    public static function createOne(): Client
    {
        $faker = (new ClientFakeFactory())->getFaker();

        return Client::create(
            firstName: $faker->firstName(),
            lastName: $faker->lastName(),
            age: new DateOfBirth(
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-60 years', '-18 years')),
            ),
            address: new AddressInUSA(
                street: $faker->streetName(),
                city: $faker->city(),
                state: $faker->randomElement(['CA', 'NY', 'NV', 'AK', 'AL', 'AR']),
                zipCode: $faker->randomElement(['35004', '35005', '35006']),
            ),
            ssn: new SSN(sprintf('418-94-%s', $faker->numberBetween(0000, 9999))),
            fico: null,
            email: new Email($faker->email()),
            phoneNumber: new AmericanPhoneNumber($faker->e164PhoneNumber()),
        );
    }
}