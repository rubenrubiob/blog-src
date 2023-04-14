<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Controller;

use rubenrubiob\Application\Command\Llibre\CrearLlibreCommand;
use rubenrubiob\Infrastructure\CommandBus\CommandBus;
use rubenrubiob\Infrastructure\Ui\Http\Request\CreateLlibreRequestBody;

final readonly class CreateLlibreController
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(CreateLlibreRequestBody $createLlibreRequestBody): void
    {
        $this->commandBus->__invoke(
            new CrearLlibreCommand(
                $createLlibreRequestBody->titol,
                $createLlibreRequestBody->autor,
            )
        );
    }
}
