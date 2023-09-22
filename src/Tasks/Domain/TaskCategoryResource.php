<?php

declare(strict_types=1);

namespace App\Tasks\Domain;

use App\Tasks\Domain\Model\TaskCategory;
use App\Tasks\Domain\Model\TaskCategoryName;
use Symfony\Component\Uid\Uuid;

interface TaskCategoryResource
{
    public function save(TaskCategory $category): void;

    public function findById(Uuid $id): ?TaskCategory;

    public function findByName(TaskCategoryName $name): ?TaskCategory;

    public function upsertByNameAndReturn(TaskCategoryName $name): TaskCategory;
}