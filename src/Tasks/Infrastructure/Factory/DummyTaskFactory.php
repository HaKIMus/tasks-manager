<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Factory;

use App\Core\Factory\TaskFactory;
use App\Core\Factory\UserFactory;
use App\Tasks\Domain\Model\Task;

/**
 * @implements TaskFactory<DummyTaskFactoryData>
 */
final class DummyTaskFactory implements TaskFactory
{

    /**
     * @param DummyTaskFactoryData $factoryData
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