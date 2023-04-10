<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Repository\Llibre;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\Exception\Repository\Llibre\LlibreDTONotFound;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;

interface GetLlibreDTOByLlibreIdRepository
{
    /** @throws LlibreDTONotFound */
    public function __invoke(LlibreId $llibreId): LlibreDTO;
}
