<?php

declare(strict_types=1);

namespace App\Tests\Unit\Common\Test;

use App\Authentication\Domain\Model\User;
use App\Common\Factory\User\DummyUserFactory;
use App\Common\Test\CreateAndFlushDummyUser;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CreateAndFlushDummyUserTest extends TestCase
{
    public function testCreateAndFlush(): void
    {
        $dummyUserFactory = $this->createMock(DummyUserFactory::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $hasher = $this->createMock(UserPasswordHasherInterface::class);

        $dummyUser = $this->createMock(User::class);
        $dummyUserFactory->expects($this->once())
            ->method('create')
            ->willReturn($dummyUser);

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($dummyUser);

        $entityManager->expects($this->once())
            ->method('flush');

        $createAndFlushDummyUser = new CreateAndFlushDummyUser($dummyUserFactory, $entityManager, $hasher);
        $user = $createAndFlushDummyUser->create();

        $this->assertSame($dummyUser, $user);
    }
}