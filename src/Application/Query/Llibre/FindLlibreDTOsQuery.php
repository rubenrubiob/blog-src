<?php

declare(strict_types=1);

namespace rubenrubiob\Application\Query\Llibre;

use rubenrubiob\Application\Query;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;

/** @implements Query<list<LlibreDTO>> */
final readonly class FindLlibreDTOsQuery implements Query
{
    public function __construct()
    {
    }
}
