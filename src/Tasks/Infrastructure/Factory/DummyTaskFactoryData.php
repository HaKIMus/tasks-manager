<?php

declare(strict_types=1);

namespace App\Tasks\Infrastructure\Factory;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\FakerDataFactory;
use App\Tasks\Domain\Model\TaskCategory;
use App\Tasks\Domain\Model\TaskCategoryName;
use App\Tasks\Domain\Model\TaskDescription;
use App\Tasks\Domain\Model\TaskName;
use App\Tasks\Domain\Model\TaskStatus;
use DateTimeInterface;
use Symfony\Component\Uid\Uuid;

final class DummyTaskFactoryData extends FakerDataFactory
{

    public function __construct(
        private readonly User $user,
        private ?Uuid $id = null,
        private ?TaskName $name = null,
        private ?TaskDescription $description = null,
        private ?TaskStatus $status = null,
        private ?TaskCategory $taskCategory = null,
        private ?DateTimeInterface $createdAt = null,
        private ?DateTimeInterface $dueTo = null,
    ) {
        parent::__construct();

        if ($id === null) {
            $this->id = Uuid::v4();
        }

        if ($name === null) {
            $this->name = new TaskName($this->faker->title());
        }

        if ($description === null) {
            $this->description = new TaskDescription($this->faker->text());
        }

        if ($status === null) {
            $this->status = $this->faker->randomElement([
                new TaskStatus(TaskStatus::STATUS_COMPLETED),
                new TaskStatus(TaskStatus::STATUS_IN_PROGRESS),
                new TaskStatus(TaskStatus::STATUS_PENDING),
            ]);
        }

        if ($taskCategory === null) {
            $this->taskCategory = new TaskCategory(
                Uuid::v4(),
                new TaskCategoryName($this->faker->title()),
            );
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

    public function getName(): ?TaskName
    {
        return $this->name;
    }

    public function getDescription(): ?TaskDescription
    {
        return $this->description;
    }

    public function getStatus(): ?TaskStatus
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