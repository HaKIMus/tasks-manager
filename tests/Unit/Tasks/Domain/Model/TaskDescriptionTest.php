<?php

declare(strict_types=1);

namespace App\Tests\Unit\Tasks\Domain\Model;

use App\Core\Exception\ValueObjectOfInvalidTypeException;
use App\Tasks\Domain\Model\TaskDescription;
use App\Tests\Common\Fake\FakeValueObject;
use PHPUnit\Framework\TestCase;

final class TaskDescriptionTest extends TestCase
{
    public function testConstructorWithValidData(): void
    {
        $description = 'This is a valid task description';
        $taskDescription = new TaskDescription($description);
        $this->assertInstanceOf(TaskDescription::class, $taskDescription);
    }

    public function testConstructorWithLongDescription(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new TaskDescription(str_repeat('a', 1001));
    }

    public function testGetDescription(): void
    {
        $description = 'Get this task done';
        $taskDescription = new TaskDescription($description);
        $this->assertEquals($description, $taskDescription->getDescription());
    }

    public function testToString(): void
    {
        $description = 'Do this task';
        $taskDescription = new TaskDescription($description);
        $this->assertEquals($description, $taskDescription->toString());
    }

    public function testEquals(): void
    {
        $taskDescription1 = new TaskDescription('Clean the room');
        $taskDescription2 = new TaskDescription('Clean the room');
        $taskDescription3 = new TaskDescription('Wash the dishes');

        $this->assertTrue($taskDescription1->equals($taskDescription2));
        $this->assertFalse($taskDescription1->equals($taskDescription3));
    }

    public function testEqualsWrongType(): void
    {
        $this->expectException(ValueObjectOfInvalidTypeException::class);

        $taskDescription = new TaskDescription('Clean the room');
        $wrongType = new FakeValueObject('Clean the room');

        $taskDescription->equals($wrongType);
    }

}