<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\DTO\Llibre;

use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;

final readonly class LlibreDTO
{
    public function __construct(
        public LlibreId $llibreId,
        public LlibreTitol $llibreTitol,
        public AutorNom $autorNom
    ) {
    }
}
