<?php

declare(strict_types=1);

namespace App\Authentication\Infrastructure\Factory;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\UserFactory;

/**
 * @implements UserFactory<DummyUserFactoryData>
 */
class DummyUserFactory implements UserFactory
{

    /**
     * @param DummyUserFactoryData $factoryData
     */
    public function create(mixed $factoryData): User
    {
        return User::createUser(
            $factoryData->getPasswordHasher(),
            $factoryData->getId(),
            $factoryData->getEmail(),
            $factoryData->getPassword(),
            $factoryData->getRoles(),
            $factoryData->getTasks()
        );
    }

}