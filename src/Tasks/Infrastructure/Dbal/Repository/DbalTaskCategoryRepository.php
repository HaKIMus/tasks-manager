<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Dbal\Repository;

use App\Tasks\Domain\Model\TaskCategory;
use App\Tasks\Domain\Model\TaskCategoryName;
use App\Tasks\Domain\TaskCategoryResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<TaskCategory>
 */
final class DbalTaskCategoryRepository extends ServiceEntityRepository implements
    TaskCategoryResource
{

    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskCategory::class);

        $this->entityManager = $this->getEntityManager();
    }

    public function findById(Uuid $id): ?TaskCategory
    {
        return $this->find($id);
    }

    public function save(TaskCategory $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function findByName(TaskCategoryName $name): ?TaskCategory
    {
        return $this->findOneBy(['name.name' => $name->toString()]);
    }

    public function upsertByNameAndReturn(TaskCategoryName $name): TaskCategory
    {
        if (!$category = $this->findByName($name)) {
            $category = new TaskCategory(Uuid::v4(), $name);
            $this->save($category);
        }

        return $category;
    }
}