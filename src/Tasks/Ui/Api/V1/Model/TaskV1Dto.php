<?php

declare(strict_types=1);

namespace App\Tasks\Ui\Api\V1\Model;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\DataFactory;
use App\Tasks\Domain\Model\TaskStatus;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final class TaskV1Dto implements DataFactory
{

    private ?User $user = null;

    public function __construct(
        readonly public string $id,
        readonly public string $name,
        readonly public string $description,
        readonly public string $status,
        readonly public string $categoryName,
        readonly public string $dueTo,
    ) {
        Assert::allNotEmpty([$id, $name, $status, $categoryName, $dueTo]);
        Assert::inArray($status, TaskStatus::STATUSES);
    }

    public static function createFromPayload(InputBag $payload): self
    {
        $id = $payload->get('id', Uuid::v4()->toRfc4122());
        $name = $payload->get('name', null);
        $description = $payload->get('description', '');
        $status = $payload->get('status', TaskStatus::STATUS_PENDING);
        $categoryName = $payload->get('category_name', 'General');
        $dueTo = $payload->get('due_to', null);

        $variables = [
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'category_name' => $categoryName,
            'due_to' => $dueTo,
        ];

        self::validate($variables);

        return new self(
            $id,
            $name,
            $description,
            $status,
            $categoryName,
            $dueTo,
        );
    }

    /**
     * @param array<string, string|null> $variables
     */
    private static function validate(array $variables): void
    {
        Assert::notNull($variables['name'], 'Value \'name\' can\'t be null');
        Assert::notNull($variables['due_to'],
            'Value \'due_to\' can\'t be null');
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

}