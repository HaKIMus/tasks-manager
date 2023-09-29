<?php

declare(strict_types=1);

namespace App\Tasks\Ui\Api\V1\Model;

use App\Tasks\Domain\Model\TaskStatus;
use Symfony\Component\HttpFoundation\InputBag;
use Webmozart\Assert\Assert;

final readonly class UpdateTaskV1Dto
{

    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?string $status,
        public ?string $categoryName,
        public ?string $dueTo,
    ) {
        if ($this->status !== null) {
            Assert::inArray($status, TaskStatus::STATUSES);
        }
    }

    public static function createFromPayload(InputBag $payload): self
    {
        $name = $payload->get('name', null);
        $description = $payload->get('description', null);
        $status = $payload->get('status', null);
        $categoryName = $payload->get('category_name', null);
        $dueTo = $payload->get('due_to', null);

        return new self(
            $name,
            $description,
            $status,
            $categoryName,
            $dueTo,
        );
    }

}