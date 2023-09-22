<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Factory\User;

use App\Authentication\Domain\Model\User;
use App\Authentication\Infrastructure\Factory\DummyUserFactory;
use App\Authentication\Infrastructure\Factory\DummyUserFactoryData;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

final class DummyUserFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $mockPasswordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $uuid = Uuid::v4();
        $email = 'test@email.com';
        $password = 'testPassword';
        $roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $tasks = $this->createMock(Collection::class);

        $factoryData = new DummyUserFactoryData(
            $mockPasswordHasher,
            $uuid,
            $email,
            $password,
            $roles,
            $tasks
        );

        $dummyUserFactory = new DummyUserFactory();

        $user = $dummyUserFactory->create($factoryData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($uuid, $user->getId());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($roles, $user->getRoles());
    }
}