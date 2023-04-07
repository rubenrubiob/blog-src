<?php

declare(strict_types=1);

namespace rubenrubiob\Application\Query\Llibre;

final readonly class GetLlibreDTOByIdQuery
{
    public function __construct(public string $id)
    {
    }
}
