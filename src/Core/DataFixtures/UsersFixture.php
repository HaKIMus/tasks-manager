<?php

declare(strict_types=1);

namespace App\Core\DataFixtures;

use App\Authentication\Domain\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class UsersFixture extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = User::createUser(
            $this->hasher,
            Uuid::v4(),
            "example@dot.com",
            "password",
            ["ROLE_USER"],
            new ArrayCollection(),
        );

        $manager->persist($user);
        $manager->flush();

        $this->addReference("user", $user);
    }
}