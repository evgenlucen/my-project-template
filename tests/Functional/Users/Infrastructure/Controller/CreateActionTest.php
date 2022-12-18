<?php

namespace App\Tests\Functional\Users\Infrastructure\Controller;

use App\Tests\Tools\FakerTools;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateActionTest extends WebTestCase
{

    use FakerTools;

    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = $this->getFaker();
    }

    public function test_create_user_action()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $this->faker->email,
                'password' => $this->faker->password,
            ])
        );

        // assert
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('command in queue', $data['message']);
    }
}
