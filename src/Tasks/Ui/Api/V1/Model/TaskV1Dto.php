<?php

declare(strict_types=1);

namespace App\Tasks\Ui\Api\V1\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class TaskV1Dto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $id,
        public string $name,
        public string $description,
        #[Assert\Choice(choices: ['pending', 'done', 'completed'])]
        public string $status,
        public string $category_id,
        public string $due_to,
    ) {
    }

}