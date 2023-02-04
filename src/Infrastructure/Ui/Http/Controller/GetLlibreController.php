<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetLlibreController
{
    public function __invoke(string $llibreId): Response
    {
        return new JsonResponse(
            [
                'id' => $llibreId,
                'titol' => 'Curial e Güelfa',
                'autor' => 'Anònim',
            ],
            Response::HTTP_OK,
        );
    }
}
