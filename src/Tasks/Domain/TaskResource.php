<?php

declare(strict_types=1);

namespace App\Tasks\Domain;

use Symfony\Component\Uid\Uuid;

interface TaskResource
{
    public function save(Task $task): void;

    public function findById(Uuid $taskId): ?Task;

    /**
     * @return array<Task>
     */
    public function findByCategory(Uuid $categoryId): array;
}