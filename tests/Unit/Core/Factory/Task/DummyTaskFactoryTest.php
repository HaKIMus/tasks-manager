<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Factory\Task;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\Task\DummyTaskFactory;
use App\Core\Factory\Task\DummyTaskFactoryData;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategory;
use App\Tasks\Domain\Model\TaskDescription;
use App\Tasks\Domain\Model\TaskName;
use App\Tasks\Domain\Model\TaskStatus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class DummyTaskFactoryTest extends TestCase
{

    public function testCreateTask(): void
    {
        $mockUser = $this->createMock(User::class);
        $taskCategory = new TaskCategory(Uuid::v4(), 'Test Category');
        $id = Uuid::v4();
        $mockDummyTaskFactoryData = new DummyTaskFactoryData(
            $mockUser,
            $id,
            new TaskName('Test Name'),
            new TaskDescription('Test Description'),
            new TaskStatus(TaskStatus::STATUS_PENDING),
            $taskCategory,
        );

        $factory = new DummyTaskFactory();
        $task = $factory->create($mockDummyTaskFactoryData);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals($id, $task->getId());
        $this->assertEquals('Test Name', $task->getName()->toString());
        $this->assertEquals('Test Description', $task->getDescription()->toString());
        $this->assertEquals('Pending', $task->getStatus()->toString());
        $this->assertSame($taskCategory, $task->getCategory());
        $this->assertEquals($mockUser, $task->getUser());
    }

}
