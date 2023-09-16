<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Repository;

use App\Authentication\Domain\Model\User;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategory;
use App\Tasks\Domain\TasksResource;
use App\Tasks\Domain\UserTasksResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class DbalTaskRepository extends ServiceEntityRepository implements
  TasksResource, UserTasksResource
{

    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);

        $this->entityManager = $this->getEntityManager();
    }

    public function findById(Uuid $taskId): ?Task
    {
        return $this->findBy([$taskId]);
    }

    public function save(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function findByCategory(TaskCategory $category): array
    {
        return $this->findBy(['category' => $category]);
    }

    public function findForUserByTaskId(User $user, Uuid $taskId): ?Task
    {
        return $this->findBy(['user' => $user, 'id' => $taskId]);
    }

    public function findForUserByCategory(User $user, TaskCategory $category): array
    {
        return $this->findBy(['user' => $user, 'category' => $category]);
    }

    public function findForUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }

}