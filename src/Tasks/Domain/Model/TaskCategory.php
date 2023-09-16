<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table(name: 'task_categories')]
class TaskCategory
{
    public function __construct(
        #[Id] #[Column(type: UuidType::NAME)] private Uuid $id,
        #[Column(type: "string")] private string $name,
    )
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}