<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\QueryBus;

use rubenrubiob\Application\Query;
use Throwable;

interface QueryBus
{
    /**
     * @template T
     *
     * @param Query<T> $query
     *
     * @return T
     *
     * @throws Throwable
     */
    public function __invoke(Query $query): mixed;
}
