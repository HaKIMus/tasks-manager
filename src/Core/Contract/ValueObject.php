<?php

declare(strict_types=1);

namespace App\Core\Contract;

use App\Core\Exception\ValueObjectOfInvalidTypeException;

readonly abstract class ValueObject
{

    /**
     * @throws ValueObjectOfInvalidTypeException
     */
    final protected function assertOfTheSameType(ValueObject $valueObject): void
    {
        if (!$valueObject instanceof static) {
            throw ValueObjectOfInvalidTypeException::fromInvalidType($valueObject);
        }
    }

    abstract public function toString(): string;

    /**
     * @param static $other
     */
    abstract public function equals(ValueObject $other): bool;
}