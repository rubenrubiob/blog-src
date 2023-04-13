<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Persistence\Dummy\Llibre;

use rubenrubiob\Domain\Repository\Llibre\GetLlibreNextIdentityRepository;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;

final class DummyGetLlibreNextIdentityRepository implements GetLlibreNextIdentityRepository
{
    private ?LlibreId $fixedLlibreId;

    public function __construct(?LlibreId $fixedId = null)
    {
        $this->fixedLlibreId = $fixedId;
    }

    public function __invoke(): LlibreId
    {
        if ($this->fixedLlibreId !== null) {
            return $this->fixedLlibreId;
        }

        return LlibreId::generate();
    }
}
