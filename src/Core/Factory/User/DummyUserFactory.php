<?php

declare(strict_types=1);

namespace App\Core\Factory\User;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\UserFactory;

/**
 * @implements UserFactory<\App\Core\Factory\User\DummyUserFactoryData>
 */
class DummyUserFactory implements UserFactory
{

    /**
     * @param \App\Core\Factory\User\DummyUserFactoryData $factoryData
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