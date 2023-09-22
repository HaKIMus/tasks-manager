<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: 'App\Tasks\Infrastructure\Dbal\Repository\DbalTaskCategoryRepository')]
#[Table(name: 'task_categories')]
class TaskCategory
{
    public function __construct(
        #[Id] #[Column(type: UuidType::NAME)] private Uuid $id,
        #[Embedded(class: TaskCategoryName::class, columnPrefix: false)] private TaskCategoryName $name,
    ) {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): TaskCategoryName
    {
        return $this->name;
    }
}