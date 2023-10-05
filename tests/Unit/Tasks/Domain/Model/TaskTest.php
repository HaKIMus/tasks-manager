<?php

declare(strict_types=1);

namespace App\Tests\Unit\Tasks\Domain\Model;

use App\Authentication\Domain\Model\User;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategory;
use App\Tasks\Domain\Model\TaskDescription;
use App\Tasks\Domain\Model\TaskName;
use App\Tasks\Domain\Model\TaskStatus;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class TaskTest extends TestCase
{
    public function testUpdateAttributes(): void
    {
        $task = $this->createSampleTask();

        $newName = new TaskName('New Task Name');
        $newStatus = new TaskStatus('completed');
        $newCategory = $this->createMock(TaskCategory::class);
        $newDueTo = new DateTimeImmutable('2023-10-10');

        $task->updateAttributes(
            name: $newName,
            status: $newStatus,
            category: $newCategory,
            dueTo: $newDueTo
        );

        $this->assertSame($newName, $task->getName());
        $this->assertSame($newStatus, $task->getStatus());
        $this->assertTrue($task->getDescription()->equals(new TaskDescription('Sample Description')));
        $this->assertSame($newCategory, $task->getCategory());
        $this->assertSame($newDueTo, $task->getDueTo());
    }

    private function createSampleTask(): Task
    {
        $uuid = Uuid::v4();
        $name = new TaskName('Sample Task');
        $description = new TaskDescription('Sample Description');
        $status = new TaskStatus('pending');
        $category = $this->createMock(TaskCategory::class);
        $dueTo = new DateTimeImmutable();
        $createdAt = new DateTimeImmutable();
        $user = $this->createMock(User::class);

        return new Task(
            id: $uuid,
            name: $name,
            description: $description,
            status: $status,
            category: $category,
            dueTo: $dueTo,
            createdAt: $createdAt,
            user: $user
        );
    }

}