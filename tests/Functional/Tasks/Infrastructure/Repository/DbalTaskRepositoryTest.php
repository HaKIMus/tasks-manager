<?php

declare(strict_types=1);

namespace App\Tests\Functional\Tasks\Infrastructure\Repository;

use App\Authentication\Infrastructure\Dbal\CreateAndFlushUser;
use App\Authentication\Infrastructure\Factory\DummyUserFactory;
use App\Authentication\Infrastructure\Factory\DummyUserFactoryData;
use App\Core\Factory\TaskFactory;
use App\Core\Factory\UserFactory;
use App\Tasks\Infrastructure\Dbal\CreateAndFlushTask;
use App\Tasks\Infrastructure\Dbal\Repository\DbalTaskRepository;
use App\Tasks\Infrastructure\Factory\DummyTaskFactory;
use App\Tasks\Infrastructure\Factory\DummyTaskFactoryData;
use App\Tests\Common\Contract\AbstractRepositoryTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends AbstractRepositoryTestCase<DbalTaskRepository>
 */
final class DbalTaskRepositoryTest extends AbstractRepositoryTestCase
{
    protected string $repositoryClass = DbalTaskRepository::class;

    private CreateAndFlushUser $createAndFlushDummyUser;

    private CreateAndFlushTask $createAndFlushDummyTask;

    private UserFactory $userFactory;

    private UserPasswordHasherInterface $hasher;
    private TaskFactory $taskFactory;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var CreateAndFlushUser $createAndFlushDummyUser */
        $createAndFlushDummyUser = $this->container->get(CreateAndFlushUser::class);
        $this->createAndFlushDummyUser = $createAndFlushDummyUser;

        /** @var CreateAndFlushTask $createAndFlushDummyTask */
        $createAndFlushDummyTask = $this->container->get(CreateAndFlushTask::class);
        $this->createAndFlushDummyTask = $createAndFlushDummyTask;

        /** @var UserFactory $userFactory */
        $userFactory = $this->container->get(DummyUserFactory::class);
        $this->userFactory = $userFactory;

        /** @var TaskFactory $taskFactory */
        $taskFactory = $this->container->get(DummyTaskFactory::class);
        $this->taskFactory = $taskFactory;

        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $this->container->get(UserPasswordHasherInterface::class);
        $this->hasher = $hasher;
    }

    public function testTaskIsBeingCreatedAndPersistedIntoDatabase(): void
    {
        $user = $this->createAndFlushDummyUser->create($this->userFactory, new DummyUserFactoryData($this->hasher));
        $this->createAndFlushDummyTask->create($this->taskFactory, new DummyTaskFactoryData($user));

        $tasks = $this->repository->findForUser($user);
        $this->assertCount(1, $tasks);

        $this->assertTrue(true);
    }

}
