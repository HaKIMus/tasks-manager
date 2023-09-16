<?php

declare(strict_types=1);

namespace App\Common\Factory\Task;

use App\Common\Factory\TaskFactory;
use App\Common\Factory\UserFactory;
use App\Tasks\Domain\Model\Task;

/**
 * @implements UserFactory<\App\Common\Factory\Task\DummyTaskFactoryData>
 */
class DummyTaskFactory implements TaskFactory
{

    /**
     * @param \App\Common\Factory\Task\DummyTaskFactoryData $factoryData
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