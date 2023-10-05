<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use App\Authentication\Domain\Model\User;
use DateTimeInterface;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
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

    public function __construct(
        #[Id] #[Column(type: UuidType::NAME)] private Uuid $id,
        #[Embedded(class: TaskName::class, columnPrefix: false)] private TaskName $name,
        #[Embedded(class: TaskDescription::class, columnPrefix: false)] private TaskDescription $description,
        #[Embedded(class: TaskStatus::class, columnPrefix: false)] private TaskStatus $status,
        #[ManyToOne(targetEntity: TaskCategory::class, cascade: ['persist'])] #[JoinColumn(name: "category_id", referencedColumnName: "id")]
        private TaskCategory $category,

        #[Column(type: "datetime")] private DateTimeInterface $dueTo,
        #[Column(type: "datetime")] private readonly DateTimeInterface $createdAt,

        #[ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
        #[JoinColumn(nullable: false)]
        private User $user,
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getName(): TaskName
    {
        return $this->name;
    }

    public function getDescription(): TaskDescription
    {
        return $this->description;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function getCategory(): TaskCategory
    {
        return $this->category;
    }

    public function getDueTo(): DateTimeInterface
    {
        return $this->dueTo;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function updateCategory(TaskCategory $taskCategory): void
    {
        $this->category = $taskCategory;
    }

    public function updateName(TaskName $name): void
    {
        $this->name = $name;
    }

    public function updateStatus(TaskStatus $status): void
    {
        $this->status = $status;
    }

    public function updateDescription(TaskDescription $description): void
    {
        $this->description = $description;
    }

    public function updateDueTo(DateTimeInterface $dueTo): void
    {
        $this->dueTo = $dueTo;
    }

    public function updateAttributes(
        ?TaskName $name = null,
        ?TaskStatus $status = null,
        ?TaskDescription $description = null,
        ?TaskCategory $category = null,
        ?DateTimeInterface $dueTo = null,
    ): void {
        $updateIfPresent = function (mixed $value, callable $block) {
            if ($value) { $block(); }
        };

        $updateIfPresent($name, fn() => $this->updateName($name));
        $updateIfPresent($status, fn() => $this->updateStatus($status));
        $updateIfPresent($description, fn() => $this->updateDescription($description));
        $updateIfPresent($category, fn() => $this->updateCategory($category));
        $updateIfPresent($dueTo, fn() => $this->updateDueTo($dueTo));
    }

}
