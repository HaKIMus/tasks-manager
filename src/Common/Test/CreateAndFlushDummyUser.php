<?php

declare(strict_types=1);

namespace App\Common\Test;

use App\Authentication\Domain\Model\User;
use App\Common\Factory\User\DummyUserFactory;
use App\Common\Factory\User\DummyUserFactoryData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class CreateAndFlushDummyUser
{

    public function __construct(
        private DummyUserFactory $dummyUserFactory,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $hasher,
    ) {}

    public function create(): User
    {
        $factoryData = new DummyUserFactoryData($this->hasher);
        $user = $this->dummyUserFactory->create($factoryData);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

}