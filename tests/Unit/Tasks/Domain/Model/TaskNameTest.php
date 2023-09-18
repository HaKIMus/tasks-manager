<?php

declare(strict_types=1);

namespace App\Tests\Unit\Tasks\Domain\Model;

use App\Core\Exception\ValueObjectOfInvalidTypeException;
use App\Tasks\Domain\Model\TaskName;
use App\Tests\Common\Fake\FakeValueObject;
use PHPUnit\Framework\TestCase;

final class TaskNameTest extends TestCase
{
    public function testConstructor(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new TaskName('');
    }

    public function testConstructorValidData(): void
    {
        $taskName = new TaskName('Valid Task Name');
        $this->assertInstanceOf(TaskName::class, $taskName);
    }

    public function testGetName(): void
    {
        $name = 'My Task';
        $taskName = new TaskName($name);
        $this->assertEquals($name, $taskName->getName());
    }

    public function testToString(): void
    {
        $name = 'Another Task';
        $taskName = new TaskName($name);
        $this->assertEquals($name, $taskName->toString());
    }

    public function testEquals(): void
    {
        $taskName1 = new TaskName('Task');
        $taskName2 = new TaskName('Task');
        $taskName3 = new TaskName('Another Task');

        $this->assertTrue($taskName1->equals($taskName2));
        $this->assertFalse($taskName1->equals($taskName3));
    }

    public function testEqualsWrongType(): void
    {
        $this->expectException(ValueObjectOfInvalidTypeException::class);

        $taskName1 = new TaskName('Task');
        $otherValueObject = new FakeValueObject('Task');

        $taskName1->equals($otherValueObject);
    }
}