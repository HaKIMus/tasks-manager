<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Factory;

use App\Core\Contract\AppException;
use App\Core\Factory\TaskFactory;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategoryName;
use App\Tasks\Domain\Model\TaskDescription;
use App\Tasks\Domain\Model\TaskName;
use App\Tasks\Domain\Model\TaskStatus;
use App\Tasks\Domain\TaskCategoryResource;
use App\Tasks\Ui\Api\V1\Model\TaskV1Dto;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @implements TaskFactory<TaskV1Dto>
 */
final readonly class ApiV1PayloadTaskFactory implements TaskFactory
{
    public function __construct(private TaskCategoryResource $categoryResource)
    {
    }

    /**
     * @param TaskV1Dto $factoryData
     */
    public function create(mixed $factoryData): Task
    {
        if (!$factoryData->hasUser()) {
            throw new InvalidArgumentException("To create a Task instance, user must be appended to the factory data.");
        }

        $category = $this->categoryResource->upsertByNameAndReturn(new TaskCategoryName($factoryData->category_name));
        $dueTo = \DateTimeImmutable::createFromFormat('Y-m-d', $factoryData->due_to);

        return new Task(
            Uuid::fromString($factoryData->id),
            new TaskName($factoryData->name),
            new TaskDescription($factoryData->description),
            new TaskStatus(mb_strtolower($factoryData->status)),
            $category,
            $dueTo,
            new \DateTimeImmutable('now'),
            $factoryData->getUser(),
        );
    }
}