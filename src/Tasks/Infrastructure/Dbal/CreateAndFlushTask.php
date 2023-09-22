<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Dbal;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\DataFactory;
use App\Core\Factory\TaskFactory;
use App\Core\Factory\UserFactory;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Infrastructure\Factory\DummyTaskFactory;
use App\Tasks\Infrastructure\Factory\DummyTaskFactoryData;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreateAndFlushTask
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * @template T of DataFactory
     * @param TaskFactory<T> $taskFactory
     * @param DataFactory $data
     * @return Task
     */
    public function create(TaskFactory $taskFactory, DataFactory $data): Task
    {
        $task = $taskFactory->create($data);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

}