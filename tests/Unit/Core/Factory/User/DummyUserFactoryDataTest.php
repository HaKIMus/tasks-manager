<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Factory\User;

use App\Core\Factory\User\DummyUserFactoryData;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

final class DummyUserFactoryDataTest extends TestCase
{
    public function testConstructorAssignsValues(): void
    {
        $mockPasswordHasher = $this->createMock(UserPasswordHasherInterface::class);

        $uuid = Uuid::v4();
        $email = 'test@email.com';
        $password = 'testPassword';
        $roles = ['ROLE_ADMIN'];
        $tasks = $this->createMock(Collection::class);

        $dummyUserFactoryData = new DummyUserFactoryData(
            $mockPasswordHasher,
            $uuid,
            $email,
            $password,
            $roles,
            $tasks
        );

        $this->assertSame($mockPasswordHasher, $dummyUserFactoryData->getPasswordHasher());
        $this->assertEquals($uuid, $dummyUserFactoryData->getId());
        $this->assertEquals($email, $dummyUserFactoryData->getEmail());
        $this->assertEquals($password, $dummyUserFactoryData->getPassword());
        $this->assertEquals($roles, $dummyUserFactoryData->getRoles());
        $this->assertSame($tasks, $dummyUserFactoryData->getTasks());
    }

    public function testConstructorAssignsDefaults(): void
    {
        $mockPasswordHasher = $this->createMock(UserPasswordHasherInterface::class);

        $dummyUserFactoryData = new DummyUserFactoryData($mockPasswordHasher);

        $this->assertSame($mockPasswordHasher, $dummyUserFactoryData->getPasswordHasher());
        $this->assertInstanceOf(Uuid::class, $dummyUserFactoryData->getId());
        $this->assertIsString($dummyUserFactoryData->getEmail());
        $this->assertIsString($dummyUserFactoryData->getPassword());
        $this->assertInstanceOf(Collection::class, $dummyUserFactoryData->getTasks());
        $this->assertEquals(['ROLE_USER'], $dummyUserFactoryData->getRoles());
    }

}