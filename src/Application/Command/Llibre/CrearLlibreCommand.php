<?php

declare(strict_types=1);

namespace rubenrubiob\Application\Command\Llibre;

final readonly class CrearLlibreCommand
{
    public function __construct(
        public string $llibreTitol,
        public string $autorNom
    ) {
    }
}
