<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Model;

use App\Core\Contract\ValueObject;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
readonly class TaskDescription extends ValueObject
{
    public function __construct(
        #[Column(type: "text")]
        private string $description
    ) {
        Assert::maxLength($description, 1000);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function toString(): string
    {
        return $this->description;
    }

    public function equals(ValueObject $other): bool
    {
        $this->assertOfTheSameType($other);

        return $this->description === $other->description;
    }

}