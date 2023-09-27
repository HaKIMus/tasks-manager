<?php

declare(strict_types=1);

namespace App\Tests\Unit\Tasks\Ui\Api\V1\Model;

use App\Authentication\Domain\Model\User;
use App\Tasks\Ui\Api\V1\Model\TaskV1Dto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Uid\Uuid;

final class TaskV1DtoTest extends TestCase
{
    public function testConstructor(): void
    {
        $dto = new TaskV1Dto(
            '1',
            'name',
            'description',
            'pending',
            'category_name',
            '2021-01-01'
        );

        $this->assertEquals('1', $dto->id);
        $this->assertEquals('name', $dto->name);
        $this->assertEquals('description', $dto->description);
        $this->assertEquals('pending', $dto->status);
        $this->assertEquals('category_name', $dto->category_name);
        $this->assertEquals('2021-01-01', $dto->due_to);
    }

    public function testHasUserAndAppendUserAndGetUser(): void
    {
        $dto = new TaskV1Dto('1', 'name', 'description', 'pending', 'category_name', '2021-01-01');
        $this->assertFalse($dto->hasUser());

        $user = $this->createMock(User::class);
        $dto->appendUser($user);

        $this->assertTrue($dto->hasUser());
        $this->assertSame($user, $dto->getUser());
    }

    public function testCreateFromPayload(): void
    {
        $payload = new InputBag([
            'id' => '2',
            'name' => 'name_from_payload',
            'description' => 'description_from_payload',
            'status' => 'completed',
            'category_name' => 'category_from_payload',
            'due_to' => '2021-01-02'
        ]);

        $dto = TaskV1Dto::createFromPayload($payload);

        $this->assertInstanceOf(TaskV1Dto::class, $dto);
        $this->assertEquals('2', $dto->id);
        $this->assertEquals('name_from_payload', $dto->name);
        $this->assertEquals('description_from_payload', $dto->description);
        $this->assertEquals('completed', $dto->status);
        $this->assertEquals('category_from_payload', $dto->category_name);
        $this->assertEquals('2021-01-02', $dto->due_to);
    }

    public function testValidation(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Value 'name' can't be null");

        $payload = new InputBag([
            'id' => Uuid::v4()->toRfc4122(),
            'name' => null,
            'description' => '',
            'status' => 'pending',
            'category_name' => 'General',
            'due_to' => '2022-01-01'
        ]);

        TaskV1Dto::createFromPayload($payload);
    }
}
