<?php

declare(strict_types=1);

namespace App\Tests\Functional\Tasks\Infrastructure\Repository;

use App\Core\Test\CreateAndFlushDummyTask;
use App\Core\Test\CreateAndFlushDummyUser;
use App\Tasks\Infrastructure\Repository\DbalTaskRepository;
use App\Tests\Common\Contract\AbstractRepositoryTestCase;

/**
 * @extends AbstractRepositoryTestCase<DbalTaskRepository>
 */
final class DbalTaskRepositoryTest extends AbstractRepositoryTestCase
{
    protected string $repositoryClass = DbalTaskRepository::class;

    private CreateAndFlushDummyUser $createAndFlushDummyUser;

    private CreateAndFlushDummyTask $createAndFlushDummyTask;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var CreateAndFlushDummyUser $createAndFlushDummyUser */
        $createAndFlushDummyUser = $this->container->get(CreateAndFlushDummyUser::class);
        $this->createAndFlushDummyUser = $createAndFlushDummyUser;

        /** @var CreateAndFlushDummyTask $createAndFlushDummyTask */
        $createAndFlushDummyTask = $this->container->get(CreateAndFlushDummyTask::class);
        $this->createAndFlushDummyTask = $createAndFlushDummyTask;
    }

    public function testSomething(): void
    {
        $user = $this->createAndFlushDummyUser->create();
        $this->createAndFlushDummyTask->create($user);

        $tasks = $this->repository->findForUser($user);
        $this->assertCount(1, $tasks);

        $this->assertTrue(true);
    }

}
