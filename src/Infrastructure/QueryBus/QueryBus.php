<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\QueryBus;

use Throwable;

interface QueryBus
{
    /** @throws Throwable */
    public function __invoke(object $query): mixed;
}
