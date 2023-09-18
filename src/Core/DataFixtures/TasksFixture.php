<?php

declare(strict_types=1);

namespace App\Core\DataFixtures;

use App\Authentication\Domain\Model\User;
use App\Tasks\Domain\Model\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class TasksFixture extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        /** @var User $user */
        $user = $this->getReference("user");

        $task = new Task(
            Uuid::v4(),
            'Task 1',
            'Task 1 description',
            Task::STATUS_PENDING,
            $this->getReference("general_category"),
            (new \DateTimeImmutable('now'))->add(new \DateInterval("P3M")),
            new \DateTimeImmutable('now'),
            $user
        );

        $user->addTask($task);

        $manager->persist($task);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsersFixture::class,
        ];
    }
}