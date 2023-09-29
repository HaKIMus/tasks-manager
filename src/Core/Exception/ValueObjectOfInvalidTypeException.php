<?php

declare(strict_types=1);

namespace App\Core\Exception;

use App\Core\Contract\AppException;

final class ValueObjectOfInvalidTypeException extends AppException
{

    public static function fromInvalidType(object $valueObject): self
    {
        return new self(
            sprintf(
                'Instance of "%s" object required',
                $valueObject::class,
            )
        );
    }

}