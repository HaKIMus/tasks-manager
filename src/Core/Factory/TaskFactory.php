<?php

declare(strict_types=1);

namespace App\Core\Factory;

use App\Core\Factory\DataFactory as DATA;
use App\Tasks\Domain\Model\Task;

/**
 * @template DATA of DataFactory
 * @extends Factory<Task, DataFactory>
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