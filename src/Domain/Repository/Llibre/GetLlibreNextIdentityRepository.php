<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Repository\Llibre;

use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;

interface GetLlibreNextIdentityRepository
{
    public function __invoke(): LlibreId;
}
