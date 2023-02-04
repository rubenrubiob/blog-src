<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\QueryBus;

use League\Tactician\CommandBus as LeagueTacticianQueryBys;

final readonly class TacticianQueryBus implements QueryBus
{
    public function __construct(private LeagueTacticianQueryBys $queryBus)
    {
    }

    public function __invoke(object $query): mixed
    {
        return $this->queryBus->handle($query);
    }
}
