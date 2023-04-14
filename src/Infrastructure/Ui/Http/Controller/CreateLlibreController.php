<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Controller;

use rubenrubiob\Application\Command\Llibre\CrearLlibreCommand;
use rubenrubiob\Infrastructure\CommandBus\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use function array_key_exists;
use function is_string;

final readonly class CreateLlibreController
{
    private const KEY_TITOL = 'titol';
    private const KEY_AUTOR = 'autor';

    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(Request $request): void
    {
        $requestContent = $this->parseAndGetRequesContent($request);

        $this->commandBus->__invoke(
            new CrearLlibreCommand(
                $requestContent[self::KEY_TITOL],
                $requestContent[self::KEY_AUTOR],
            )
        );
    }

    /**
     * @return array{
     *      titol: string,
     *      autor: string,
     *     ...
     * }
     *
     * @throws BadRequestHttpException
     */
    private function parseAndGetRequesContent(Request $request): array
    {
        $requestContent = $request->toArray();

        if (!array_key_exists(self::KEY_TITOL, $requestContent)) {
            throw new BadRequestHttpException('Missing "titol"');
        }

        if (!is_string($requestContent[self::KEY_TITOL])) {
            throw new BadRequestHttpException('"titol" format is not valid');
        }

        if (!array_key_exists(self::KEY_AUTOR, $requestContent)) {
            throw new BadRequestHttpException('Missing "autor"');
        }

        if (!is_string($requestContent[self::KEY_AUTOR])) {
            throw new BadRequestHttpException('"autor" format is not valid');
        }

        return $requestContent;
    }
}
