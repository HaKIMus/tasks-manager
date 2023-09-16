<?php

declare(strict_types=1);

namespace App\Common\DataFixtures;

use App\Tasks\Domain\Model\TaskCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class TaskCategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $taskCategory = new TaskCategory(
            Uuid::v4(),
            "General",
        );

        $manager->persist($taskCategory);
        $manager->flush();

        $this->addReference("general_category", $taskCategory);
    }
}