<?php

declare(strict_types=1);

namespace App\Tasks\Domain;

use App\Authentication\Domain\Model\User;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategory;
use Symfony\Component\Uid\Uuid;

interface UserTasksResource
{
    public function save(Task $task): void;

    public function findForUserByTaskId(User $user, Uuid $taskId): ?Task;

    /**
     * @return array<Task>
     */
    public function findForUser(User $user): array;

    /**
     * @return array<Task>
     */
    public function findForUserByCategory(User $user, TaskCategory $category): array;
}