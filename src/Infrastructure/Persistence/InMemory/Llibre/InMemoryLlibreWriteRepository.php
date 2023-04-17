<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Persistence\InMemory\Llibre;

use rubenrubiob\Domain\Model\Llibre;
use rubenrubiob\Domain\Repository\Llibre\LlibreWriteRepository;

final class InMemoryLlibreWriteRepository implements LlibreWriteRepository
{
    /** @var array<non-empty-string, Llibre> */
    public array $llibres = [];

    public function __construct()
    {
    }

    public function afegir(Llibre $llibre): void
    {
        $this->llibres[$llibre->llibreId()->toString()] = $llibre;
    }
}
