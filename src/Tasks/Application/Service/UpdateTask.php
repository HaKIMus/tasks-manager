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
        if ($updateTaskDto->name !== null) {
            $task->updateName(new TaskName($updateTaskDto->name));
        }

        if ($updateTaskDto->status !== null) {
            $task->updateStatus(new TaskStatus($updateTaskDto->status));
        }

        if ($updateTaskDto->description !== null) {
            $task->updateDescription(new TaskDescription($updateTaskDto->description));
        }

        if ($updateTaskDto->categoryName !== null) {
            $name = new TaskCategoryName($updateTaskDto->categoryName);
            $taskCategory
                = $this->taskCategoryResource->upsertByNameAndReturn($name);

            $task->updateCategory($taskCategory);
        }

        if ($updateTaskDto->dueTo !== null) {
            $task->updateDueTo(DateTimeImmutable::createFromFormat('Y-m-d',
                $updateTaskDto->dueTo));
        }

        $this->taskResource->save($task);
    }

}