<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Request;

use rubenrubiob\Infrastructure\Symfony\Http\Request\APIRequestBody;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateLlibreRequestBody implements APIRequestBody
{
    public function __construct(
        #[Assert\NotBlank(normalizer: 'trim')]
        public string $titol,
        #[Assert\NotBlank(normalizer: 'trim')]
        public string $autor
    ) {
    }
}
