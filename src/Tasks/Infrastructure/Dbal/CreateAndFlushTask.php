<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Dbal;

use App\Authentication\Domain\Model\User;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Infrastructure\Factory\DummyTaskFactory;
use App\Tasks\Infrastructure\Factory\DummyTaskFactoryData;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreateAndFlushTask
{

    public function __construct(
        private DummyTaskFactory $dummyTaskFactory,
        private EntityManagerInterface $entityManager,
    ) {}

    public function create(User $user): Task
    {
        $factoryData = new DummyTaskFactoryData($user);
        $task = $this->dummyTaskFactory->create($factoryData);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

}