<?php

declare(strict_types=1);

namespace App\Common\Factory;

/**
 * @template T
 * @template DATA of DataFactory
 */
interface Factory
{
    /**
     * @param DATA $factoryData
     * @return T
     */
    public function create(mixed $factoryData): mixed;
}