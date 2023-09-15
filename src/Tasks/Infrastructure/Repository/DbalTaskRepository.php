<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Repository;

use App\Tasks\Domain\Task;
use App\Tasks\Domain\TaskResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class DbalTaskRepository extends ServiceEntityRepository implements TaskResource
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);

        $this->entityManager = $this->getEntityManager();
    }

    public function findById(Uuid $taskId): ?Task {
        return $this->find($taskId);
    }

    public function save(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function findByCategory(Uuid $categoryId): array
    {
        return $this->findBy(['category' => $categoryId]);
    }
}