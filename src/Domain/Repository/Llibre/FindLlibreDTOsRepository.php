<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Repository\Llibre;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;

interface FindLlibreDTOsRepository
{
    /** @return list<LlibreDTO> */
    public function __invoke(): array;
}
