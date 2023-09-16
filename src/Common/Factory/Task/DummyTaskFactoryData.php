<?php

declare(strict_types=1);

namespace App\Common\Factory\Task;

use App\Authentication\Domain\Model\User;
use App\Common\Factory\DataFactory;
use App\Tasks\Domain\Model\Task;
use App\Tasks\Domain\Model\TaskCategory;
use DateTimeInterface;
use Symfony\Component\Uid\Uuid;

class DummyTaskFactoryData extends DataFactory
{

    public function __construct(
        private readonly User $user,
        private ?Uuid $id = null,
        private ?string $name = null,
        private ?string $description = null,
        private ?string $status = null,
        private ?TaskCategory $taskCategory = null,
        private ?DateTimeInterface $createdAt = null,
        private ?DateTimeInterface $dueTo = null,
    ) {
        parent::__construct();

        if ($id === null) {
            $this->id = Uuid::v4();
        }

        if ($name === null) {
            $this->name = $this->faker->title();
        }

        if ($description === null) {
            $this->description = $this->faker->text();
        }

        if ($status === null) {
            $this->status = $this->faker->randomElement([
                Task::STATUS_COMPLETED,
                Task::STATUS_IN_PROGRESS,
                Task::STATUS_PENDING,
            ]);
        }

        if ($taskCategory === null) {
            $this->taskCategory = new TaskCategory(Uuid::v4(),
                $this->faker->title());
        }

        if ($createdAt === null) {
            $this->createdAt = $this->faker->dateTime();
        }

        if ($dueTo === null) {
            $this->dueTo = $this->faker->dateTime();
        }
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getTaskCategory(): ?TaskCategory
    {
        return $this->taskCategory;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getDueTo(): ?DateTimeInterface
    {
        return $this->dueTo;
    }

    public function getUser(): User
    {
        return $this->user;
    }

}