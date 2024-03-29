<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Exception\Repository\Llibre;

use Exception;
use rubenrubiob\Domain\Exception\Repository\NotFound;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;

use function sprintf;

final class LlibreDTONotFound extends Exception implements NotFound
{
    public static function withLlibreId(LlibreId $llibreId): self
    {
        return new self(
            sprintf(
                'LlibreDTO with LlibreId "%s" not found',
                $llibreId->toString(),
            )
        );
    }
}
