<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Model;

use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;

final readonly class Llibre
{
    private function __construct(
        private LlibreId $llibreId,
        private LlibreTitol $llibreTitol,
        private AutorNom $autorNom
    ) {
    }

    public static function create(LlibreId $llibreId, LlibreTitol $llibreTitol, AutorNom $autorNom): self
    {
        return new self($llibreId, $llibreTitol, $autorNom);
    }

    public function llibreId(): LlibreId
    {
        return $this->llibreId;
    }

    public function llibreTitol(): LlibreTitol
    {
        return $this->llibreTitol;
    }

    public function autorNom(): AutorNom
    {
        return $this->autorNom;
    }
}
