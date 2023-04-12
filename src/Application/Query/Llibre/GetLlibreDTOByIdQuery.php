<?php

declare(strict_types=1);

namespace rubenrubiob\Application\Query\Llibre;

use rubenrubiob\Application\Query;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;

/** @implements Query<LlibreDTO> */
final readonly class GetLlibreDTOByIdQuery implements Query
{
    public function __construct(public string $id)
    {
    }
}
