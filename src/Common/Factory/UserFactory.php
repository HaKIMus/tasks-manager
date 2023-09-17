<?php

declare(strict_types=1);

namespace App\Common\Factory;

use App\Authentication\Domain\Model\User;

/**
 * @template DATA of DataFactory
 * @implements Factory<User, DataFactory>
 */
interface UserFactory extends Factory
{
    /**
     * @param DATA $factoryData
     *
     * @return User
     */
    public function create(mixed $factoryData): mixed;
}