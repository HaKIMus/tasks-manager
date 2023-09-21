<?php

declare(strict_types=1);

namespace App\Core\Test;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\User\DummyUserFactory;
use App\Core\Factory\User\DummyUserFactoryData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[When(env: 'test')]
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