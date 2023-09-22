<?php

declare(strict_types=1);

namespace App\Tasks\Ui\Api\V1\Model;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\DataFactory;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskV1Dto implements DataFactory
{
    private ?User $user = null;

    public function __construct(
        #[Assert\NotBlank]
        readonly public string $id,
        #[Assert\NotBlank]
        readonly public string $name,
        #[Assert\NotBlank]
        readonly public string $description,
        #[Assert\NotBlank]
        #[Assert\Choice(choices: ['pending', 'done', 'completed'])]
        readonly public string $status,
        #[Assert\NotBlank]
        readonly public string $category_name,
        #[Assert\NotBlank]
        #[Assert\DateTime(format: 'Y-m-d')]
        readonly public string $due_to,
    ) {
    }

    public function hasUser(): bool
    {
        return $this->user !== null;
    }

    public function appendUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public static function createFromPayload(InputBag $payload): self
    {
        $id = $payload->get('id', null);
        $name = $payload->get('name', null);
        $description = $payload->get('description', null);
        $status = $payload->get('status', null);
        $categoryName = $payload->get('category_name', null);
        $due_to = $payload->get('due_to', null);

        return new self(
            $id,
            $name,
            $description,
            $status,
            $categoryName,
            $due_to,
        );
    }

}