<?php

declare(strict_types=1);

namespace App\Common\Factory;

use Faker\Factory;
use Faker\Generator;

abstract class DataFactory {
    protected Generator $faker;

    public function __construct() {
        $this->faker = Factory::create();
    }
}