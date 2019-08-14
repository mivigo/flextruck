<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixtures
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, User::class, function (User $user) {
            $user->setEmail(sprintf('random_user%d@example.com', $this->faker->randomNumber()));
            $encoded = $this->encoder->encodePassword($user, 'root');

            $user->setPassword($encoded);

            return $user;
        });

        $manager->flush();
    }
}
