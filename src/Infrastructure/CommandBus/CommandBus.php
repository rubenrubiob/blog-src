<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\CommandBus;

use Throwable;

interface CommandBus
{
    /** @throws Throwable */
    public function __invoke(object $command): void;
}
