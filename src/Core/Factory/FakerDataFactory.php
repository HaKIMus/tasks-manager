<?php

declare(strict_types=1);

namespace App\Core\Factory;

use Faker\Factory;
use Faker\Generator;

abstract class FakerDataFactory implements DataFactory
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
}