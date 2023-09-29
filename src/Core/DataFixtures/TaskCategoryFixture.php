<?php

declare(strict_types=1);

namespace App\Core\DataFixtures;

use App\Tasks\Domain\Model\TaskCategory;
use App\Tasks\Domain\Model\TaskCategoryName;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class TaskCategoryFixture extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $taskCategory = new TaskCategory(
            Uuid::v4(),
            new TaskCategoryName("General"),
        );

        $manager->persist($taskCategory);
        $manager->flush();

        $this->addReference("general_category", $taskCategory);
    }

}