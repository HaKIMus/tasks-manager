<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Test;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\TaskFactory;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Infrastructure\Dbal\CreateAndFlushTask;
use App\Tasks\Infrastructure\Factory\DummyTaskFactoryData;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

final class CreateAndFlushDummyTaskTest extends TestCase
{

    public function testCreateAndFlush(): void
    {
        $dummyTaskFactory = $this->createMock(TaskFactory::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $dummyTask = $this->createMock(Task::class);
        $dummyTaskFactory->expects($this->once())
            ->method('create')
            ->willReturn($dummyTask);

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($dummyTask);

        $entityManager->expects($this->once())
            ->method('flush');

        $user = $this->createMock(User::class);

        $createAndFlushDummyTask
            = new CreateAndFlushTask($entityManager);
        $task = $createAndFlushDummyTask->create($dummyTaskFactory, new DummyTaskFactoryData($user));

        $this->assertSame($dummyTask, $task);
    }

}