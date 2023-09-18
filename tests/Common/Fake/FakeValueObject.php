<?php

declare(strict_types=1);

namespace App\Tests\Common\Fake;

use App\Core\Contract\ValueObject;

readonly class FakeValueObject extends ValueObject
{
    public function __construct(private mixed $value) {}

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function toString(): string
    {
        return json_encode($this->value);
    }

    public function equals(ValueObject $other): bool
    {
        self::assertOfTheSameType($other);

        return $this->value === $other->value;
    }

}