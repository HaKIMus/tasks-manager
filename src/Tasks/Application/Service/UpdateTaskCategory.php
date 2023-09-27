<?php

declare(strict_types=1);

namespace App\Tasks\Application\Service;

use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategoryName;
use App\Tasks\Domain\TaskCategoryResource;
use App\Tasks\Domain\TaskResource;

final readonly class UpdateTaskCategory
{
    public function __construct(
        private TaskCategoryResource $taskCategoryResource,
        private TaskResource $taskResource,
    ) {
    }

    public function update(Task $task, string $categoryName): void
    {
        $name = new TaskCategoryName($categoryName);
        $taskCategory = $this->taskCategoryResource->upsertByNameAndReturn($name);

        $task->updateCategory($taskCategory);
        $this->taskResource->save($task);
    }
}