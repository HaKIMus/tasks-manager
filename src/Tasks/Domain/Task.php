<?php

declare(strict_types=1);

namespace App\Tasks\Domain;

use ApiPlatform\Metadata\ApiResource;
use App\Authentication\Domain\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table(name: 'tasks')]
#[ApiResource]
class Task
{
    const STATUS_PENDING = 'Pending';
    const STATUS_IN_PROGRESS = 'In Progress';
    const STATUS_COMPLETED = 'Completed';

    public function __construct(
        #[Id] #[Column(type: UuidType::NAME)] private Uuid $id,
        #[Column(type: "string")] private string $name,
        #[Column(type: "text")] private string $description,
        #[Column(type: 'string', length: 50)] private string $status,
        #[ManyToOne(targetEntity: TaskCategory::class)] #[JoinColumn(name: "category_id", referencedColumnName: "id")]
        private TaskCategory $category,

        #[Column(type: "datetime")] private \DateTimeInterface $dueTo,
        #[Column(type: "datetime")] private readonly \DateTimeInterface $createdAt,

        #[ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
        #[JoinColumn(nullable: false)]
        private User $user,
    ) {
        $this->validateStatus($status);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }


    public function getUser(): User
    {
        return $this->user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCategory(): TaskCategory
    {
        return $this->category;
    }

    public function getDueTo(): \DateTimeInterface
    {
        return $this->dueTo;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    private function validateStatus(string $status): void
    {
        match ($status) {
            self::STATUS_PENDING, self::STATUS_IN_PROGRESS, self::STATUS_COMPLETED => true,
            default => throw new \InvalidArgumentException('Invalid status'),
        };
    }
}
