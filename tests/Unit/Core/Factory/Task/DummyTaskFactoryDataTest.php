<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Factory\Task;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\Task\DummyTaskFactoryData;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategory;
use App\Tasks\Domain\Model\TaskDescription;
use App\Tasks\Domain\Model\TaskName;
use App\Tasks\Domain\Model\TaskStatus;
use App\Tests\Unit\Tasks\Domain\Model\TaskStatusTest;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class DummyTaskFactoryDataTest extends TestCase
{
    public function testFactoryDataCreation(): void
    {
        $mockUser = $this->createMock(User::class);

        $dummyTaskFactoryData = new DummyTaskFactoryData($mockUser);

        // Validate properties are set by constructor
        $this->assertInstanceOf(Uuid::class, $dummyTaskFactoryData->getId());
        $this->assertInstanceOf(TaskName::class, $dummyTaskFactoryData->getName());
        $this->assertInstanceOf(TaskDescription::class, $dummyTaskFactoryData->getDescription());
        $this->assertInstanceOf(TaskStatus::class, $dummyTaskFactoryData->getStatus());
        $this->assertInstanceOf(TaskCategory::class, $dummyTaskFactoryData->getTaskCategory());
        $this->assertInstanceOf(DateTimeInterface::class, $dummyTaskFactoryData->getCreatedAt());
        $this->assertInstanceOf(DateTimeInterface::class, $dummyTaskFactoryData->getDueTo());
        $this->assertSame($mockUser, $dummyTaskFactoryData->getUser());
    }

    public function testFactoryDataCreationWithAllFieldsSet(): void
    {
        $mockUser = $this->createMock(User::class);
        $mockTaskCategory = $this->createMock(TaskCategory::class);
        $mockDateTime = $this->createMock(DateTimeImmutable::class);

        $dummyTaskFactoryData = new DummyTaskFactoryData(
            $mockUser,
            Uuid::v4(),
            new TaskName('Test Name'),
            new TaskDescription('Test Description'),
            new TaskStatus('Pending'),
            $mockTaskCategory,
            $mockDateTime,
            $mockDateTime
        );

        $this->assertNotNull($dummyTaskFactoryData->getId());
        $this->assertEquals('Test Name', $dummyTaskFactoryData->getName()->toString());
        $this->assertEquals(new TaskDescription('Test Description'), $dummyTaskFactoryData->getDescription());
        $this->assertEquals(new TaskStatus('Pending'), $dummyTaskFactoryData->getStatus());
        $this->assertSame($mockTaskCategory, $dummyTaskFactoryData->getTaskCategory());
        $this->assertSame($mockDateTime, $dummyTaskFactoryData->getCreatedAt());
        $this->assertSame($mockDateTime, $dummyTaskFactoryData->getDueTo());
        $this->assertSame($mockUser, $dummyTaskFactoryData->getUser());
    }
}