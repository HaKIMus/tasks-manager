<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Dbal;

use App\Core\Factory\DataFactory;
use App\Core\Factory\TaskFactory;
use App\Tasks\Domain\Model\Task;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreateAndFlushTask
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * @template T of DataFactory
     * @param TaskFactory<T> $taskFactory
     * @param DataFactory    $data
     *
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