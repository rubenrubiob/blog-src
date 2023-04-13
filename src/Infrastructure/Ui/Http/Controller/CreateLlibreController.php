<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Controller;

use rubenrubiob\Application\Command\Llibre\CrearLlibreCommand;
use rubenrubiob\Infrastructure\CommandBus\CommandBus;
use Symfony\Component\HttpFoundation\Request;

final readonly class CreateLlibreController
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(Request $request): void
    {
        $requestContent = $request->toArray();

        $this->commandBus->__invoke(
            new CrearLlibreCommand(
                $requestContent['titol'],
                $requestContent['autor'],
            )
        );
    }
}
