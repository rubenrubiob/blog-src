<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Response\Presenter;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;

final readonly class LlibreDTOPresenter
{
    /** @return array{
     *     'id': non-empty-string,
     *     'titol': non-empty-string,
     *     'autor': non-empty-string
     * }
     */
    public function __invoke(LlibreDTO $llibreDTO): array
    {
        return [
            'id' => $llibreDTO->llibreId->toString(),
            'titol' => $llibreDTO->llibreTitol->toString(),
            'autor' => $llibreDTO->autorNom->toString(),
        ];
    }
}
