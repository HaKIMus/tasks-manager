<?php

declare(strict_types=1);

namespace App\Tasks\Domain\Model;

use App\Core\Contract\ValueObject;
use App\Core\Exception\ValueObjectOfInvalidTypeException;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
readonly class TaskStatus extends ValueObject
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in progress';
    public const STATUS_COMPLETED = 'completed';

    public function __construct(
        #[Column(type: 'string', length: 50)]
        private string $status
    ) {
        match ($this->status) {
            self::STATUS_PENDING, self::STATUS_IN_PROGRESS, self::STATUS_COMPLETED => true,
            default => throw new InvalidArgumentException('Invalid status'),
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

    /**
     * @param static $other
     * @throws ValueObjectOfInvalidTypeException
     */
    public function equals(ValueObject $other): bool
    {
        $this->assertOfTheSameType($other);

        return $this->status === $other->status;
    }

}