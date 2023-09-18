<?php

declare(strict_types=1);

namespace App\Core\Factory\Task;

use App\Core\Factory\TaskFactory;
use App\Core\Factory\UserFactory;
use App\Tasks\Domain\Model\Task;

/**
 * @implements UserFactory<\App\Core\Factory\Task\DummyTaskFactoryData>
 */
class DummyTaskFactory implements TaskFactory
{

    /**
     * @param \App\Core\Factory\Task\DummyTaskFactoryData $factoryData
     */
    public function create(mixed $factoryData): Task
    {
        return new Task(
            $factoryData->getId(),
            $factoryData->getName(),
            $factoryData->getDescription(),
            $factoryData->getStatus(),
            $factoryData->getTaskCategory(),
            $factoryData->getDueTo(),
            $factoryData->getCreatedAt(),
            $factoryData->getUser(),
        );
    }

}