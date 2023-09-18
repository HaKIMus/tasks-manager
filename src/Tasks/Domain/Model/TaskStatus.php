<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Model;

use App\Core\Contract\ValueObject;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
readonly class TaskStatus extends ValueObject
{
    const STATUS_PENDING = 'Pending';
    const STATUS_IN_PROGRESS = 'In Progress';
    const STATUS_COMPLETED = 'Completed';

    public function __construct(
        #[Column(type: 'string', length: 50)]
        private string $status
    ) {
        match ($status) {
            self::STATUS_PENDING, self::STATUS_IN_PROGRESS, self::STATUS_COMPLETED => true,
            default => throw new \InvalidArgumentException('Invalid status'),
        };
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function toString(): string
    {
        return $this->status;
    }

    public function equals(ValueObject $other): bool
    {
        $this->assertOfTheSameType($other);

        return $this->status === $other->status;
    }

}