<?php

declare(strict_types=1);

namespace App\Common\Factory;

use App\Common\Factory\DataFactory as DATA;
use App\Tasks\Domain\Model\Task;

/**
 * @template DATA of DataFactory
 * @implements Factory<Task, DataFactory>
 */
interface TaskFactory extends Factory
{
    /**
     * @param DATA $factoryData
     *
     * @return Task
     */
    public function create(mixed $factoryData): mixed;
}