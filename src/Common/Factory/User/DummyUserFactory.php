<?php

declare(strict_types=1);

namespace App\Common\Factory\User;

use App\Authentication\Domain\Model\User;
use App\Common\Factory\UserFactory;

/**
 * @implements UserFactory<\App\Common\Factory\User\DummyUserFactoryData>
 */
class DummyUserFactory implements UserFactory
{

    /**
     * @param \App\Common\Factory\User\DummyUserFactoryData $factoryData
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