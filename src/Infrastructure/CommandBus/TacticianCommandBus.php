<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\CommandBus;

use League\Tactician\CommandBus as LeagueTacticianCommandBus;

final readonly class TacticianCommandBus implements CommandBus
{
    public function __construct(
        private LeagueTacticianCommandBus $commandBus,
    ) {
    }

    public function __invoke(object $command): void
    {
        $this->commandBus->handle($command);
    }
}
