<?php

declare(strict_types=1);

namespace App\Common\Test;

use App\Authentication\Domain\Model\User;
use App\Common\Factory\Task\DummyTaskFactory;
use App\Common\Factory\Task\DummyTaskFactoryData;
use App\Tasks\Domain\Model\Task;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreateAndFlushDummyTask
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