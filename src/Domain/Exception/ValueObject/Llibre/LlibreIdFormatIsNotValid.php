<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Exception\ValueObject\Llibre;

use Exception;

use rubenrubiob\Domain\Exception\ValueObject\InvalidValueObject;

use function sprintf;

final class LlibreIdFormatIsNotValid extends Exception implements InvalidValueObject
{
    public static function withValue(string $value): self
    {
        return new self(
            sprintf(
                'LlibreId provided format "%s" is not a valid UUID',
                $value,
            )
        );
    }
}
