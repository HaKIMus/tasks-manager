<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Model;

use App\Core\Contract\ValueObject;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
readonly class TaskName extends ValueObject
{
    public function __construct(
        #[Column(type: 'string', length: 255)]
        private string $name
    ) {
        Assert::notEmpty($name);
        Assert::lengthBetween($name, 1, 255);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function equals(ValueObject $other): bool
    {
        $this->assertOfTheSameType($other);

        return $this->name === $other->name;
    }

}