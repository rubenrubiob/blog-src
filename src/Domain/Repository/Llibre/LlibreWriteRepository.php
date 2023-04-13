<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Repository\Llibre;

use rubenrubiob\Domain\Model\Llibre;

interface LlibreWriteRepository
{
    public function afegir(Llibre $llibre): void;
}
