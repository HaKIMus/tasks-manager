<?php

declare(strict_types=1);

namespace App\Tests\Unit\Tasks\Domain\Model;

use App\Core\Exception\ValueObjectOfInvalidTypeException;
use App\Tasks\Domain\Model\TaskStatus;
use App\Tests\Common\Fake\FakeValueObject;
use PHPUnit\Framework\TestCase;

final class TaskStatusTest extends TestCase
{
    public function testConstructorWithInvalidStatus(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new TaskStatus('InvalidStatus');
    }

    public function testConstructorWithValidStatus(): void
    {
        $status = TaskStatus::STATUS_PENDING;
        $taskStatus = new TaskStatus($status);
        $this->assertInstanceOf(TaskStatus::class, $taskStatus);
    }

    public function testGetStatus(): void
    {
        $status = TaskStatus::STATUS_PENDING;
        $taskStatus = new TaskStatus($status);
        $this->assertEquals($status, $taskStatus->getStatus());
    }

    public function testToString(): void
    {
        $status = TaskStatus::STATUS_PENDING;
        $taskStatus = new TaskStatus($status);
        $this->assertEquals($status, $taskStatus->toString());
    }

    public function testEquals(): void
    {
        $taskStatus1 = new TaskStatus(TaskStatus::STATUS_PENDING);
        $taskStatus2 = new TaskStatus(TaskStatus::STATUS_PENDING);
        $taskStatus3 = new TaskStatus(TaskStatus::STATUS_COMPLETED);

        $this->assertTrue($taskStatus1->equals($taskStatus2));
        $this->assertFalse($taskStatus1->equals($taskStatus3));
    }

    public function testEqualsWrongType(): void
    {
        $this->expectException(ValueObjectOfInvalidTypeException::class);

        $taskStatus = new TaskStatus(TaskStatus::STATUS_PENDING);
        $wrongType = new FakeValueObject(TaskStatus::STATUS_PENDING);

        $taskStatus->equals($wrongType);
    }

}