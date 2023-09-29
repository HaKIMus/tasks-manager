<?php

declare(strict_types=1);

namespace App\Core\Factory;

/**
 * @template T
 * @template DATA of DataFactory
 */
interface Factory
{

    /**
     * @param DATA $factoryData
     *
     * @return T
     */
    public function create(mixed $factoryData): mixed;

}