<?php

declare(strict_types=1);

namespace App\Tasks\Domain;

use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategory;
use Symfony\Component\Uid\Uuid;

interface TasksResource
{
    public function save(Task $task): void;

    public function findById(Uuid $taskId): ?Task;

    /**
     * @return array<Task>
     */
    public function findByCategory(TaskCategory $category): array;
}