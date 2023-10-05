<?php

declare(strict_types=1);

namespace App\Tasks\Application\Service;

use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategoryName;
use App\Tasks\Domain\Model\TaskDescription;
use App\Tasks\Domain\Model\TaskName;
use App\Tasks\Domain\Model\TaskStatus;
use App\Tasks\Domain\TaskCategoryResource;
use App\Tasks\Domain\TaskResource;
use App\Tasks\Ui\Api\V1\Model\UpdateTaskV1Dto;
use DateTimeImmutable;

final readonly class UpdateTask
{

    public function __construct(
        private TaskCategoryResource $taskCategoryResource,
        private TaskResource $taskResource,
    ) {}

    public function update(Task $task, UpdateTaskV1Dto $updateTaskDto): void
    {
        $task->updateAttributes(
            name: $updateTaskDto->name !== null ? new TaskName($updateTaskDto->name) : null,
            status: $updateTaskDto->status !== null ? new TaskStatus($updateTaskDto->status) : null,
            description: $updateTaskDto->description !== null ? new TaskDescription($updateTaskDto->description) : null,
            category: $updateTaskDto->categoryName !== null ? $this->taskCategoryResource->upsertByNameAndReturn(new TaskCategoryName($updateTaskDto->categoryName)) : null,
            dueTo: $updateTaskDto->dueTo !== null ? DateTimeImmutable::createFromFormat('Y-m-d', $updateTaskDto->dueTo) : null,
        );

        $this->taskResource->save($task);
    }

}