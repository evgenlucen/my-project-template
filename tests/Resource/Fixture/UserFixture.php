<?php

namespace Resource\Fixture;

use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Resource\Tools\FakerTools;

class UserFixture extends Fixture
{
    use FakerTools;

    public const REFERENCE = 'user';

    public function load(ObjectManager $manager)
    {
        $email = $this->getFaker()->email;
        $password = $this->getFaker()->password;
        $user = (new UserFactory())->create($email,$password);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE, $user);
    }
}